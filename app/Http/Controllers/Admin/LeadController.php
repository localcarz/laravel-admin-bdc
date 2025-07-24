<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LeadController extends Controller
{

    public function index(Request $request, $id = null)
    {


        if ($id != null) {
            $notification = DB::table('notifications')->where('id', $id)->update(['is_read' => '1']);
        }

        $leads = DB::table('leads')
            ->join('users', 'leads.user_id', '=', 'users.id')
            ->join('dealers', 'leads.dealer_id', '=', 'dealers.id')
            ->join('main_inventories', 'leads.inventory_id', '=', 'main_inventories.id')
            ->select(
                'leads.id',
                'leads.user_id as lead_user_id',
                'leads.dealer_id as lead_dealer_id',
                'leads.invoice_status as invoice_status',
                'leads.status as lead_status',
                'leads.inventory_id as lead_inventory_id',
                'main_inventories.title',
                'main_inventories.make',
                'dealers.id as dealer_id',
                'dealers.name as dealer_name',
                'dealers.city as dealer_city',
                'dealers.state as dealer_state',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
            )
            ->when($request->has('search.value'), function ($query) use ($request) {
                $search = strtolower($request->input('search.value'));
                $query->where(function ($q) use ($search) {
                    $q->where(DB::raw('LOWER(main_inventories.title)'), 'LIKE', "%{$search}%")
                        ->orWhere(DB::raw('LOWER(main_inventories.make)'), 'LIKE', "%{$search}%")
                        ->orWhere(DB::raw('LOWER(dealers.city)'), 'LIKE', "%{$search}%")
                        ->orWhere(DB::raw('LOWER(dealers.state)'), 'LIKE', "%{$search}%")
                        ->orWhere(DB::raw('LOWER(users.name)'), 'LIKE', "%{$search}%")
                        ->orWhere(DB::raw('LOWER(users.email)'), 'LIKE', "%{$search}%")
                        ->orWhere(DB::raw('LOWER(users.phone)'), 'LIKE', "%{$search}%")
                        ->orWhere(DB::raw('LOWER(leads.status)'), 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('leads.id', 'asc');


        // $inventory = MainInventory::query();
        // $data['inventory_make'] = $inventory->distinct('make')->pluck('id', 'make')->toArray();

        // $users = DB::table('dealers')->whereNotNull('city')
        //     ->where('city', '!=', '')
        //     ->whereNotNull('state')
        //     ->where('state', '!=', '')
        //     ->get(['id', 'name', 'city', 'state']);
        // $data['inventory_dealer_name'] = $users->pluck('id', 'name')->toArray();
        // $data['inventory_dealer_city'] = $users->pluck('id', 'city')->toArray();
        // $data['inventory_dealer_state'] = $users->pluck('id', 'state')->toArray();

        // ksort($data['inventory_make']);
        // ksort($data['inventory_dealer_name']);
        // ksort($data['inventory_dealer_city']);
        // ksort($data['inventory_dealer_state']);


        // if ($request->showTrashed == 'true') {
        //     $info = $this->leadService->getTrashedItem();
        // } else {
        //     $info = $this->leadService->getItemByFilter($request);
        // }

        // $rowCount = $this->leadService->getRowCount();
        // $trashedCount = $this->leadService->getTrashedCount();


        if ($request->ajax()) {
            return DataTables::of($leads)->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($user) {
                    return $user->id; // Use any unique identifier for your rows
                })
                ->addColumn('check', function ($row) {
                    $html = '<div class=" text-center">
                        <input type="checkbox" name="lead_id[]" value="' . $row->id . '" class="mt-2 check1 check-row">
                        <input type="hidden" name="dealer_id[]" value="' . $row->lead_dealer_id . '" class="mt-2 check1 check-row">

                    </div>';
                    return $html;
                })

                ->addColumn('status', function ($row) {
                    $html = '<p>' . ($row->lead_status == 1 ? 'Active' : 'Inactive') . '</p>';
                    return $html;
                })
                ->addColumn('dealer_name', function ($row) {
                    // Fixed dealer name handling
                    $dealerName = $row->dealer_name ?? 'Null';
                    $url = route('admin.dealer.profile', $row->lead_dealer_id);
                    return "<a href='{$url}'>{$dealerName}</a>";
                })
                ->addColumn('action', function ($row) {
                    $html = '<a data-id="' . $row->id . '" href="javascript:void(0);" style="color:white; margin-right: 6px !important" class="btn btn-info btn-sm message_view common_read"><i class="fas fa-comment-alt"></i></a>' .
                        // '<a href="' . route('admin.single.lead.view', $row->id) . '" style="margin-right: 6px !important" class="btn btn-success btn-sm lead_view common_read"><i class="fa fa-eye"></i></a>' .
                        '<a href="javascript:void(0);" style="margin-right: 6px !important" class="btn btn-warning btn-sm common_read send-adf-mail" data-id="' . $row->id . '" title="ADF Mail"><i class="fa fa-paper-plane"></i></a>' .
                        '<a href="javascript:void(0);" style="margin-right: 6px !important" class="btn btn-primary btn-sm common_read send-mail" data-id="' . $row->id . '" title="Mail"><i class="fa fa-envelope"></i></a>' .
                        '<a href="javascript:void(0);" class="btn btn-danger common_read btn-sm lead_delete" data-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';
                    return $html;
                })
                // ->addColumn('action', function ($row) {
                //     if ($row->trashed()) {
                //         $html = '<a href="' . route('admin.lead.restore', $row->id) . '" class="btn btn-info btn-sm restore" data-id="' . $row->id . '"><i class="fa fa-recycle"></i></a> ' .
                //             '<a href="' . route('admin.lead.permanent.delete', $row->id) . '" class="btn btn-danger btn-sm c-delete" data-id="' . $row->id . '"><i class="fa fa-exclamation-triangle"></i></a>';
                //     } else {
                //         $html = '<a data-id="' . $row->id . '" href="javascript:void(0);" style="color:white; margin-right: 6px !important" class="btn btn-info btn-sm message_view common_read"><i class="fas fa-comment-alt"></i></a>' .
                //             '<a href="' . route('admin.single.lead.view', $row->id) . '" style="margin-right: 6px !important" class="btn btn-success btn-sm lead_view common_read"><i class="fa fa-eye"></i></a>' .
                //             '<a href="javascript:void(0);" style="margin-right: 6px !important" class="btn btn-warning btn-sm common_read send-adf-mail" data-id="' . $row->id . '" title="ADF Mail"><i class="fa fa-paper-plane"></i></a>' .
                //             '<a href="javascript:void(0);" style="margin-right: 6px !important" class="btn btn-primary btn-sm common_read send-mail" data-id="' . $row->id . '" title="Mail"><i class="fa fa-envelope"></i></a>' .
                //             '<a href="javascript:void(0);" class="btn btn-danger common_read btn-sm lead_delete" data-id="' . $row->id . '"><i class="fa fa-trash"></i></a>';
                //     }
                //     return $html;
                // })
                ->rawColumns(['action', 'status', 'check', 'dealer_name'])
                // ->with([
                //     'allRow' => $rowCount,
                //     'trashedRow' => $trashedCount,
                // ])
                ->smart(true)
                ->make(true);
        }
        // return view('backend.admin.lead.lead_show', compact('leads'), $data);
        return view('Admin.lead');
    }
}
