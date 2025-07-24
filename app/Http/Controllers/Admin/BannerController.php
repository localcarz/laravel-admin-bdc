<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use PDO;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('banners')
                ->select(
                    'banners.id',
                    'banners.name',
                    'banners.image',
                    'banners.position',
                    'banners.status',
                    'banners.created_at'
                );

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    return $row->id;
                })
                ->addColumn('name', function ($row) {
                    return ucwords($row->name);
                })
                ->addColumn('position', function ($row) {
                    return ucwords($row->position);
                })
                ->addColumn('image', function ($row) {
                    // dd($row->image);
                    $frontendUrl = config('frontend.url');
                    return $row->image
                        ? '<img src=' . $frontendUrl . '/dashboard/images/banners/' . $row->image . ' style="width: 150px; height: auto; border-radius: 4px;">'
                        : '<span class="text-muted">No image</span>';
                })
                ->addColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $btnClass = $row->status ? 'btn-success' : 'btn-warning';
                    $btnIcon = $row->status ? 'fa-check-circle' : 'fa-times-circle';
                    return '
                        <div class="btn-group" role="group">
                            <button class="btn btn-secondary btn-sm link-btn mr-1" data-id="' . $row->id . '" title="URL">
                                <i class="fas fa-link"></i>
                            </button>
                            <button class="btn btn-info btn-sm view-btn mr-1" data-id="' . $row->id . '" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-primary btn-sm edit-btn mr-1" data-id="' . $row->id . '" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn ' . $btnClass . ' btn-sm status-toggle mr-1" data-id="' . $row->id . '" data-status="' . $row->status . '">
                                <i class="fas ' . $btnIcon . '"></i>
                            </button>
                            </div>
                            ';
                    // <button class="btn btn-danger btn-sm delete-btn " data-id="' . $row->id . '" title="Delete">
                    //     <i class="fas fa-trash"></i>
                    // </button>
                })

                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        $banners = DB::table('banners')->pluck('id', 'position');
        return view('Admin.banner', compact('banners'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|in:top,middle,bottom',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('dashboard/images/banners'), $imageName);

            DB::table('banners')->insert([
                'name' => $request->name,
                'position' => $request->position,
                'image' => $imageName,
                'status' => $request->status ?? 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Banner created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create banner: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request)
    {
        $banner = DB::table('banners')
            ->where('id', $request->id)
            ->first();

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $banner
        ]);
    }

    public function edit(Request $request)
    {
        $banner = DB::table('banners')
            ->where('id', $request->id)
            ->first();

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $banner
        ]);
    }

    public function link(Request $request)
    {
        $banner = DB::table('banners')
            ->where('id', $request->id)
            ->first();

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $banner
        ]);
    }

    public function linkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:banners,id',
            'editUrl' => 'required|string',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = [
                'url' => $request->editUrl,
                'new_window' => $request->status ?? 0,
                'updated_at' => now()
            ];

            DB::table('banners')
                ->where('id', $request->id)
                ->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Banner URL updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner URL: ' . $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:banners,id',
            'name' => 'required|string|max:255',
            // 'position' => 'required|in:top,middle,bottom',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = [
                'name' => $request->name,
                'position' => $request->position,
                'status' => $request->status ?? 0,
                'updated_at' => now()
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                try {
                    $frontendUrl = config('frontend.url');
                    // Send the image to Application B's API
                    $response = Http::asMultipart()
                        ->attach('image', file_get_contents($image->getRealPath()), $imageName)
                        ->post($frontendUrl . '/api/banner/upload', [
                            'is_update' => $request->isMethod('put') || $request->isMethod('patch'), // Check if it's an update
                            'old_image' => $request->has('old_image') ? $request->old_image : null, // Pass old image name if updating
                        ]);

                    if (!$response->successful()) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to upload image: ' . $response->body(),
                        ], 500);
                    }

                    $updateData['image'] = $imageName; // Store new image name
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error uploading image: ' . $e->getMessage(),
                    ], 500);
                }
            }
            // if ($request->hasFile('image')) {
            //     $imageName = time() . '.' . $request->image->extension();
            //     $request->image->move(public_path('dashboard/images/banners'), $imageName);
            //     $updateData['image'] = $imageName;
            // }

            DB::table('banners')
                ->where('id', $request->id)
                ->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Banner updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner: ' . $e->getMessage()
            ], 500);
        }
    }

    public function status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:banners,id',
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::table('banners')
                ->where('id', $request->id)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Banner status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            DB::table('banners')
                ->where('id', $request->id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Banner deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete banner: ' . $e->getMessage()
            ], 500);
        }
    }
}
