<?php

namespace App\Model\Admin;

use App\Model\Common\Customer;
use Auth;
use App\Model\BaseModel;
use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\Common\File;
use DB;
use App\Model\Common\Notification;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Commission extends Model
{
    public const CHUA_QUYET_TOAN = 10;
    public const DA_QUYET_TOAN = 20;
    public const TU_CHOI = 30;

    public const STATUSES = [
        [
            'id' => self::CHUA_QUYET_TOAN,
            'name' => 'Chưa quyết toán',
            'type' => 'danger'
        ],
        [
            'id' => self::DA_QUYET_TOAN,
            'name' => 'Đã quyết toán',
            'type' => 'success'
        ],
        [
            'id' => self::TU_CHOI,
            'name' => 'Từ chối',
            'type' => 'danger'
        ],
    ];

    public const STATUSES_WITHKEY = [
        10 => [
            'id' => self::CHUA_QUYET_TOAN,
            'name' => 'Chưa quyết toán',
            'type' => 'danger'
        ],
        20 =>  [
            'id' => self::DA_QUYET_TOAN,
            'name' => 'Đã quyết toán',
            'type' => 'success'
        ],
        30 =>  [
            'id' => self::TU_CHOI,
            'name' => 'Từ chối',
            'type' => 'danger'
        ],
    ];


    public static function searchByFilter($request)
    {
        $result = self::query()->with(['order', 'nguoigioithieu', 'nguoiduocgioithieu']);

        if (!empty($request->order_code)) {
            $result = $result->whereHas('order', function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->order_code . '%');
            });
        }

        if (!empty($request->code)) {
            $result = $result->where('code', 'like', '%' . $request->code . '%');
        }

        $result = $result->orderBy('created_at', 'desc')->get();
        return $result;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function nguoigioithieu()
    {
        return $this->belongsTo(Customer::class, 'nguoi_gioi_thieu_id');
    }

    public function nguoiduocgioithieu()
    {
        return $this->belongsTo(Customer::class, 'nguoi_duoc_gioi_thieu_id');
    }
}
