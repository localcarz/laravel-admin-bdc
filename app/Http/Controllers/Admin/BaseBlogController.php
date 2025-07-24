<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BaseBlogController extends Controller
{
    protected function getBlogData(Request $request, $typeId, $viewName, $routeName, $title)
    {
        if ($request->ajax()) {
            $data = DB::table('blogs')
                ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
                ->join('blog_sub_categories', 'blogs.sub_category_id', '=', 'blog_sub_categories.id')
                ->select(
                    'blogs.id',
                    'blogs.title',
                    'blogs.img',
                    'blogs.status',
                    'blogs.created_at',
                    'blog_categories.name as category_name',
                    'blog_sub_categories.name as sub_category_name'
                )
                ->where('sub_category_id', $typeId)
                ->orderBy('created_at', 'desc');

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    static $count = 1;
                    return $count++;
                })
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('img', function ($row) {
                    $frontendUrl = config('frontend.url');
                    return $row->img ?
                        '<img src="' . $frontendUrl . '/frontend/assets/images/blog/' .
                        $row->img . '" width="50">' :
                        'No Image';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';

                    // View button
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="view btn btn-info btn-sm mr-1" title="View">
                                <i class="fas fa-eye"></i>
                             </a>';

                    // Edit button
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm mr-1" title="Edit">
                                <i class="fas fa-edit"></i>
                             </a>';

                    // Status toggle button
                    $btnClass = $row->status ? 'btn-success' : 'btn-warning';
                    $btnIcon = $row->status ? 'fa-check-circle' : 'fa-times-circle';

                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" data-status="' . $row->status . '" class="status-toggle btn btn-sm mr-1 ' . $btnClass . '" title="Toggle Status">
                                <i class="fas ' . $btnIcon . '"></i>
                             </a>';

                    // Delete button
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm" title="Delete">
                                <i class="fas fa-trash"></i>
                             </a>';

                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['img', 'status', 'action'])
                ->make(true);
        }

        $categories = DB::table('blog_categories')->select('id', 'name', 'slug', 'status', 'img')->get();
        $sub_categories = DB::table('blog_sub_categories')->select('id', 'name', 'slug', 'status', 'img')->get();

        return view($viewName, [
            'type' => $title,
            'route' => 'admin.' . $routeName,
            'categories' => $categories,
            'sub_categories' => $sub_categories
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'sub_category_id' => 'required|exists:blog_sub_categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'user_id' => auth('admin')->id(),
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'type' => $request->sub_category_id,
                'title' => $request->title,
                'slug' => strtolower(str_replace(' ', '-', trim($request->title))),
                'sub_title' => $request->sub_title,
                'description' => $request->description,
                'status' => $request->status,
                'blog_status' => 1,
                'seo_description' => $request->seo_description,
                'seo_keyword' => $request->seo_keywords,
                'hash_keyword' => $request->hashKeyword,
                'created_at' => now(),
                'updated_at' => now(),
            ];


            if ($request->hasFile('image')) {
                $frontendUrl = config('frontend.url');
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                try {
                    // Send the image to Application B's API
                    $response = Http::asMultipart()
                        ->attach('image', file_get_contents($image->getRealPath()), $imageName)
                        ->post($frontendUrl . '/api/blog/upload');

                    if (!$response->successful()) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to upload image: ' . $response->body(),
                        ], 500);
                    }

                    $data['img'] = $imageName;
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error uploading image: ' . $e->getMessage(),
                    ], 500);
                }
            }
            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $imageName = time() . '.' . $image->getClientOriginalExtension();

            //     // First store the file temporarily
            //     $path = $image->storeAs('temp', $imageName);
            //     // Then attach it to the HTTP request
            //     $response = Http::attach(
            //         'image',
            //         file_get_contents($image->getRealPath()),
            //         $imageName
            //     )->post('http://carbazar.test/api/upload');
            //     dd($response);

            //     //new code for public
            //     // $carbazarPath = config('app.FRONTEND_PATH'). '\frontend\assets\images\blog';
            //     // $image->move($carbazarPath, $imageName);

            //     //old image code for local
            //     // $image->move(public_path('frontend/assets/images/blog'), $imageName);
            //     $data['img'] = $imageName;
            //     // Optionally, delete the temporary file after upload
            //     Storage::delete($path);
            // }

            DB::table('blogs')->insert($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Blog created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error creating blog: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        $blog = DB::table('blogs')
            ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
            ->join('blog_sub_categories', 'blogs.sub_category_id', '=', 'blog_sub_categories.id')
            ->select(
                'blogs.*',
                'blog_categories.name as category_name',
                'blog_sub_categories.name as sub_category_name'
            )
            ->where('blogs.id', $request->id)
            ->first();

        return response()->json($blog);
    }

    public function show(Request $request)
    {
        $blog = DB::table('blogs')
            ->join('blog_categories', 'blogs.category_id', '=', 'blog_categories.id')
            ->join('blog_sub_categories', 'blogs.sub_category_id', '=', 'blog_sub_categories.id')
            ->select(
                'blogs.*',
                'blog_categories.name as category_name',
                'blog_sub_categories.name as sub_category_name'
            )
            ->where('blogs.id', $request->id)
            ->first();

        return response()->json($blog);
    }

    public function status(Request $request)
    {
        try {
            DB::table('blogs')
                ->where('id', $request->id)
                ->update(['status' => $request->status]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating status'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:blogs,id',
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'sub_category_id' => 'required|exists:blog_sub_categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'title' => $request->title,
                'slug' => strtolower(str_replace(' ', '-', trim($request->title))),
                'sub_title' => $request->sub_title,
                'description' => $request->description,
                'status' => $request->status,
                'seo_description' => $request->seo_description,
                'seo_keyword' => $request->seo_keywords,
                'hash_keyword' => $request->hashKeyword,
                'updated_at' => now(),
            ];

            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $imageName = time() . '.' . $image->getClientOriginalExtension();
            //     // $carbazarPath = env('CARBAZAR_PUBLIC_PATH') . '\frontend\assets\images\blog';
            //     $carbazarPath = config('app.FRONTEND_PATH') . '\frontend\assets\images\blog';
            //     $image->move($carbazarPath, $imageName);
            //     // $image->move(public_path('frontend/assets/images/blog'), $imageName);
            //     $data['img'] = $imageName;
            // }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                try {
                    $frontendUrl = config('frontend.url');
                    // Send the image to Application B's API
                    $response = Http::asMultipart()
                        ->attach('image', file_get_contents($image->getRealPath()), $imageName)
                        ->post($frontendUrl . '/api/blog/upload', [
                            'is_update' => $request->isMethod('put') || $request->isMethod('patch'), // Check if it's an update
                            'old_image' => $request->has('old_image') ? $request->old_image : null, // Pass old image name if updating
                        ]);

                    if (!$response->successful()) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to upload image: ' . $response->body(),
                        ], 500);
                    }

                    $data['img'] = $imageName; // Store new image name
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error uploading image: ' . $e->getMessage(),
                    ], 500);
                }
            }

            // if ($request->hasFile('image')) {
            //     $image = $request->file('image');
            //     $imageName = time() . '.' . $image->getClientOriginalExtension();
            //     try {
            //         // Send the image to Application B's API
            //         $response = Http::asMultipart()
            //             ->attach('image', file_get_contents($image->getRealPath()), $imageName)
            //             ->post('http://carbazar.test/api/blog/upload');

            //         if (!$response->successful()) {
            //             return response()->json([
            //                 'status' => 'error',
            //                 'message' => 'Failed to upload image: ' . $response->body(),
            //             ], 500);
            //         }

            //         $data['img'] = $imageName;
            //     } catch (\Exception $e) {
            //         return response()->json([
            //             'status' => 'error',
            //             'message' => 'Error uploading image: ' . $e->getMessage(),
            //         ], 500);
            //     }
            // }

            DB::table('blogs')
                ->where('id', $request->id)
                ->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Blog updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating blog: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::table('blogs')->where('id', $request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Blog deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting blog'
            ], 500);
        }
    }
}
