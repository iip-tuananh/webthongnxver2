<?php

namespace App\Http\Controllers\Admin;

use App\Mail\OrderActive;
use App\Model\Admin\Commission;
use App\Model\Admin\Config;
use App\Model\Admin\Order;
use App\Model\Admin\OrderDetail;
use Illuminate\Http\Request;
use App\Model\Admin\Commission as ThisModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use \stdClass;

use Rap2hpoutre\FastExcel\FastExcel;
use PDF;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\Common\Customer;

class CommissionController extends Controller
{
    protected $view = 'admin.commissions';
    protected $route = 'commissions';

    public function index()
    {
        return view($this->view . '.index');
    }

    // Hàm lấy data cho bảng list
    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);
        return Datatables::of($objects)
            ->editColumn('code', function ($object) {
                return '<a href="'.route('commissions.show', $object->id).'">' . $object->code . '</a>';
            })
            ->editColumn('nguoi_gioi_thieu_id', function ($object) {
                $name = data_get($object, 'nguoigioithieu.fullname', '');
                $code = data_get($object, 'nguoigioithieu.code', '');
                return '<a href="'.route('customers.show', $object->nguoi_gioi_thieu_id).'">' . e($name) . ' (' . e($code) . ')</a>';
            })
            ->editColumn('nguoi_duoc_gioi_thieu_id', function ($object) {
                $name = data_get($object, 'nguoiduocgioithieu.fullname', '');
                $code = data_get($object, 'nguoiduocgioithieu.code', '');
                return '<a href="'.route('customers.show', $object->nguoi_duoc_gioi_thieu_id).'">' . e($name) . ' (' . e($code) . ')</a>';
            })
            ->editColumn('base_amount', function ($object) {
                return number_format($object->base_amount);
            })
            ->editColumn('percent', function ($object) {
                return number_format($object->percent);
            })
            ->editColumn('amount_commissions', function ($object) {
                return number_format($object->amount_commissions);
            })
            ->editColumn('order_id', function ($object) {
                $orderCode = @$object->order->code ?? '';
                return '<a href = "'.route('orders.show', $object->order_id).'" title = "Xem chi tiết">' . $orderCode . '</a>';
            })
            ->editColumn('created_at', function ($object) {
                return Carbon::parse($object->created_at)->format('d/m/Y H:i');
            })
            ->editColumn('updated_at', function ($object) {
                return Carbon::parse($object->updated_at)->format('d/m/Y H:i');
            })
            ->addColumn('action', function ($object) {
                $result = '<div class="btn-group btn-action">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class = "fa fa-cog"></i>
                </button>
                <div class="dropdown-menu">';
                $result = $result . ' <a href="'.route('commissions.show', $object->id).'" title="Xem chi tiết" class="dropdown-item"><i class="fa fa-angle-right"></i>Xem chi tiết</a>';
//                $result = $result . ' <a href="'.route('orders.delete', $object->id).'" title="xóa" class="dropdown-item confirm"><i class="fa fa-angle-right"></i>Xóa</a>';

                $result = $result . '</div></div>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['order_id', 'action', 'nguoi_gioi_thieu_id','nguoi_duoc_gioi_thieu_id', 'code'])
            ->make(true);
    }

    public function show(Request $request, $id) {
        $order = Commission::query()
            ->with(['nguoigioithieu', 'nguoiduocgioithieu', 'order'])
            ->find($id);

        return view($this->view . '.show', compact('order'));
    }

    public function delete($id) {
        $order = Commission::query()->where('id', $id)->first();

        $order->delete();

        $message = array(
            "message" => "Thao tác thành công!",
            "alert-type" => "success"
        );

        return redirect()->route($this->route.'.index')->with($message);
    }

    public function updateStatus(Request $request)
    {
        $obj = Commission::query()->find($request->commission_id);

        $obj->status = $request->status;
        $obj->save();

        $customer = $obj->nguoiduocgioithieu;
        if ($customer->email && $obj->status == Commission::DA_QUYET_TOAN) {
//                Mail::to($customer->email)->send(new OrderActive($data, $config));
        }

        return Response::json(['success' => true, 'message' => 'Đã cập nhật trạng thái hoa hồng']);
    }
}
