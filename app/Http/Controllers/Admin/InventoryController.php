<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainInventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('main_inventories')
                ->join('dealers', 'main_inventories.deal_id', '=', 'dealers.id')
                ->select(
                    'main_inventories.id',
                    'main_inventories.stock',
                    'main_inventories.vin',
                    'main_inventories.year',
                    'main_inventories.make',
                    'main_inventories.model',
                    'main_inventories.deal_id',
                    'main_inventories.created_date',
                    'main_inventories.payment_date',
                    'main_inventories.created_at',
                    'main_inventories.active_till',
                    'main_inventories.inventory_status',
                    'main_inventories.is_visibility',
                    'main_inventories.package',
                    'dealers.name as dealer_name',
                    'dealers.email as dealer_email',
                    'dealers.city as dealer_city',
                    'dealers.state as dealer_state'
                )
                // ->orderBy('main_inventories.created_date', 'desc')
                ->orderBy('main_inventories.id', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($row) {
                    return $row->id;
                })
                ->addColumn('is_visibility', function ($row) {
                    return $row->is_visibility
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('date', function ($row) {
                    return Carbon::parse($row->created_date)->format('m-d-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';

                    // View button
                    $btn .= '<button class="btn btn-info btn-sm view-btn mr-1" data-id="' . $row->id . '" title="View">
                <i class="fas fa-eye"></i>
             </button>';

                    // Edit button - proper route for inventory
                    $btn .= '<a href="/admin/inventory/' . $row->id . '/edit" class="btn btn-primary btn-sm mr-1" title="Edit">
                <i class="fas fa-edit"></i>
             </a>';

                    // Status toggle button
                    $btnClass = $row->is_visibility ? 'btn-success' : 'btn-warning';
                    $btnIcon = $row->is_visibility ? 'fa-check-circle' : 'fa-times-circle';

                    $btn .= '<button class="btn btn-sm mr-1 status-toggle ' . $btnClass . '" data-id="' . $row->id . '" data-status="' . $row->is_visibility . '" title="Toggle Status">
                <i class="fas ' . $btnIcon . '"></i>
             </button>';

                    // Delete button
                    $btn .= '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '" title="Delete">
                <i class="fas fa-trash"></i>
             </button>';

                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['action', 'is_visibility'])
                ->make(true);
        }
        return view('Admin.inventories');
    }


    // Add these methods to your InventoryController class

    public function create()
    {
        $dealers = DB::table('dealers')->where('status', 1)->get();
        return view('Admin.inventory-create', compact('dealers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deal_id' => 'required|exists:dealers,id',
            'stock' => 'required|string|max:50',
            'vin' => 'required|string|max:50|unique:main_inventories,vin',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'package' => 'nullable|string|max:100',
            'inventory_status' => 'required|in:active,inactive,sold',
            'is_visibility' => 'required|boolean',
            'created_date' => 'required|date',
            // 'active_till' => 'required|date|after:created_date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $inventory = new MainInventory();
            $inventory->fill($request->all());
            $inventory->save();

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Inventory created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create inventory: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $inventory = MainInventory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'deal_id' => 'required|exists:dealers,id',
            'stock' => 'required|string|max:50',
            'vin' => 'required|string|max:50|unique:main_inventories,vin,' . $id,
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'package' => 'nullable|string|max:100',
            'inventory_status' => 'required|in:active,inactive,sold',
            'is_visibility' => 'required|boolean',
            'created_date' => 'required|date',
            // 'active_till' => 'required|date|after:created_date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $inventory->fill($request->all());
            $inventory->save();

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Inventory updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update inventory: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $inventory = DB::table('main_inventories')
            ->join('dealers', 'main_inventories.deal_id', '=', 'dealers.id')
            ->select(
                'main_inventories.*',
                'dealers.name as dealer_name',
                'dealers.email as dealer_email',
                'dealers.phone as dealer_phone',
                'dealers.city as dealer_city',
                'dealers.state as dealer_state'
            )
            ->where('main_inventories.id', $id)
            ->first();

        if (!$inventory) {
            return response()->json([
                'success' => false,
                'message' => 'Inventory not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $inventory
        ]);
    }

    public function edit($id)
    {
        $inventory = MainInventory::with('dealer')->findOrFail($id);
        $dealers = DB::table('dealers')->where('status', 1)->get();
        return view('Admin.inventory-edit', compact('inventory', 'dealers'));
    }

    public function status(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
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
            $inventory = MainInventory::findOrFail($id);
            $inventory->is_visibility = $request->status;
            $inventory->save();

            return response()->json([
                'success' => true,
                'message' => 'Inventory status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update inventory status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $inventory = MainInventory::findOrFail($id);
            $inventory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Inventory deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete inventory: ' . $e->getMessage()
            ], 500);
        }
    }
}
