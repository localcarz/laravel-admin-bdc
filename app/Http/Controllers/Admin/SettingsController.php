<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('general_settings')->first();

            $frontendUrl = config('frontend.url') . '/frontend/assets/images/logos/';

            return DataTables::of(collect([$data]))
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    return $row->id;
                })
                ->addColumn('logo', function ($row) use ($frontendUrl) {
                    $html = '<img width="50%" src="' . $frontendUrl . $row->image . '" />';
                    return $html;
                })
                ->addColumn('slider', function ($row) use ($frontendUrl) {
                    $html = '<img width="50%" src="' . $frontendUrl . $row->slider_image . '" />';
                    return $html;
                })
                ->addColumn('favicon', function ($row) use ($frontendUrl) {
                    $html = '<img width="40%" src="' . $frontendUrl . $row->fav_image . '" />';
                    return $html;
                })
                ->addColumn('upload_by', function ($row) {
                    return $row->userName->name ?? 'N/A';
                })

                ->addColumn('action', function ($row) {
                    $html = '<a
                data-id="' . $row->id . '"
                style="margin-right:3px"
                href="javascript:void(0);"

                class="btn btn-info btn-sm edit-btn editLogo">
                <i class="fa fa-edit"></i>
                </a>';
                    return $html;
                })
                ->rawColumns(['action', 'logo', 'favicon', 'slider'])
                ->make(true);
        }
        return view('Admin.settings');
    }

    public function edit(Request $request)
    {
        $general_settings = DB::table('general_settings')
            ->where('id', $request->id)
            ->first();

        if (!$general_settings) {
            return response()->json([
                'success' => false,
                'message' => 'Settings not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $general_settings
        ]);
    }

    // public function update(Request $request)
    // {
    //     if ($request->ajax()) {
    //         // Find the record first
    //         $setting = DB::table('general_settings')->where('id', $request->id)->first();

    //         if (!$setting) {
    //             return response()->json(['status' => 'error', 'message' => 'Setting not found'], 404);
    //         }

    //         $updateData = [];

    //         // Handle regular image upload
    //         $frontendUrl = config('frontend.url');
    //         if ($request->hasFile('image')) {
    //             $image = $request->file('image');
    //             $imageName = time() . '.' . $image->getClientOriginalExtension();
    //             try {
    //                 // Send the image to Application B's API
    //                 $response = Http::asMultipart()
    //                     ->attach('image', file_get_contents($image->getRealPath()), $imageName)
    //                     ->post($frontendUrl . '/api/setting/upload');

    //                 if (!$response->successful()) {
    //                     return response()->json([
    //                         'status' => 'error',
    //                         'message' => 'Failed to upload image: ' . $response->body(),
    //                     ], 500);
    //                 }

    //                 $data['img'] = $imageName;
    //             } catch (\Exception $e) {
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'message' => 'Error uploading image: ' . $e->getMessage(),
    //                 ], 500);
    //             }



    //             $path = 'frontend/assets/images/logos/';
    //             $image = $request->file('image');
    //             $imageName = time() . '.' . $image->getClientOriginalExtension();

    //             // Delete old image if exists
    //             if (!empty($setting->image) && file_exists(public_path($path . $setting->image))) {
    //                 unlink(public_path($path . $setting->image));
    //             }

    //             $image->move(public_path($path), $imageName);
    //             $updateData['image'] = $imageName;
    //         }

    //         // Handle favicon upload
    //         if ($request->hasFile('fav_image')) {
    //             $path = 'frontend/assets/images/logos/';
    //             $fav_image = $request->file('fav_image');
    //             $imageName = time() . '_fav.' . $fav_image->getClientOriginalExtension();

    //             if (!empty($setting->fav_image) && file_exists(public_path($path . $setting->fav_image))) {
    //                 unlink(public_path($path . $setting->fav_image));
    //             }

    //             $fav_image->move(public_path($path), $imageName);
    //             $updateData['fav_image'] = $imageName;
    //         }

    //         // Handle slider image upload
    //         if ($request->hasFile('slider_image')) {
    //             $path = 'frontend/assets/images/logos/';
    //             $slider_image = $request->file('slider_image');
    //             $imageName = time() . '_slider.' . $slider_image->getClientOriginalExtension();

    //             if (!empty($setting->slider_image) && file_exists(public_path($path . $setting->slider_image))) {
    //                 unlink(public_path($path . $setting->slider_image));
    //             }

    //             $slider_image->move(public_path($path), $imageName);
    //             $updateData['slider_image'] = $imageName;
    //         }

    //         // Update other fields
    //         $updateData = array_merge($updateData, [
    //             'site_title' => $request->site_title,
    //             'email' => $request->email,
    //             'slider_title' => $request->slider_title,
    //             'slider_subtitle' => $request->slider_subtitle,
    //             'phone' => $request->phone,
    //             'pagination' => $request->pagination,
    //             'separator' => $request->separator,
    //             'timezone' => $request->timezone,
    //             'language' => $request->language,
    //             'date_formate' => $request->date_formate,
    //             'time_formate' => $request->time_formate,
    //             'apr_rate' => $request->apr,
    //         ]);

    //         // Perform the update
    //         DB::table('general_settings')
    //             ->where('id', $request->id)
    //             ->update($updateData);

    //         return response()->json([
    //             // 'status' => 'success',
    //             'success' => true,
    //             'message' => 'General Settings updated successfully'
    //         ]);
    //     }

    //     return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
    // }
    public function update(Request $request)
    {
        if ($request->ajax()) {
            try {
                $setting = DB::table('general_settings')->where('id', $request->id)->first();

                if (!$setting) {
                    throw new \Exception('Setting not found', 404);
                }

                $updateData = [];
                $frontendUrl = rtrim(config('frontend.url'), '/');

                // Define all image fields and their types
                $imageFields = [
                    'image' => 'logo',
                    'fav_image' => 'favicon',
                    'slider_image' => 'slider'
                ];

                foreach ($imageFields as $field => $type) {
                    if ($request->hasFile($field)) {
                        try {
                            $image = $request->file($field);
                            $apiUrl = "{$frontendUrl}/api/setting/upload";

                            Log::info("Attempting to upload {$type} image to: {$apiUrl}");

                            $response = Http::asMultipart()
                                ->attach(
                                    'image',
                                    fopen($image->getRealPath(), 'r'),
                                    $image->getClientOriginalName(),
                                    [
                                        'headers' => [
                                            'Content-Type' => $image->getMimeType()
                                        ]
                                    ]
                                )
                                ->post($apiUrl, [
                                    'type' => $type,
                                    'is_update' => true,
                                    'old_image' => $setting->$field ?? null,
                                    '_token' => csrf_token()
                                ]);

                            Log::info("Upload response:", $response->json());

                            if (!$response->successful()) {
                                throw new \Exception("Failed to upload {$type} image. Status: {$response->status()}");
                            }

                            $responseData = $response->json();
                            if (!isset($responseData['image_name'])) {
                                throw new \Exception("Invalid response format from image upload");
                            }

                            $updateData[$field] = $responseData['image_name'];
                        } catch (\Exception $e) {
                            Log::error("{$type} image upload failed: " . $e->getMessage());
                            continue; // Skip this image but continue with others
                        }
                    }
                }

                // Rest of your update logic...

            } catch (\Exception $e) {
                Log::error("Settings Update Error: {$e->getMessage()}");
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        }
        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }
}
