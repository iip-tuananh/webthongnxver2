<?php

namespace App\Http\Controllers\Front;

use App\Http\Traits\ResponseTrait;
use App\Mail\NewOrder;
use App\Model\Admin\Config;
use App\Model\Admin\Order;
use App\Model\Admin\OrderDetail;
use App\Model\Admin\Product;
use App\Model\Common\Customer;
use App\Model\Common\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Category;
use App\Model\Admin\Voucher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Kjmtrue\VietnamZone\Models\Province;
use Vanthao03596\HCVN\Models\District;
use Vanthao03596\HCVN\Models\Province as Vanthao03596Province;
use Vanthao03596\HCVN\Models\Ward;

class RegisterController extends Controller
{
    use ResponseTrait;


    public function showRegistrationForm()
    {
        return view('site.customer.register');
    }

    public function registerSubmit(Request $request)
    {
        $request->merge([
            'referred_code' => trim((string) $request->input('referred_code')),
        ]);

        $rules = [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'password' => 'required|min:6|string',
            'password-rep' => 'required|same:password',
            'referred_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::exists('customers', 'code')->where(function ($q) {
                    $q->where('status', 1);
                }),

            ],
        ];

        $messages = [
            'fullname.required' => 'Vui lòng nhập họ và tên',
            'fullname.string' => 'Họ tên phải là chuỗi ký tự',
            'fullname.max' => 'Họ tên không được vượt quá :max ký tự',

            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email không được vượt quá :max ký tự',
            'email.unique' => 'Email này đã được sử dụng',

            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu',

            'password-rep.required' => 'Vui lòng nhập lại mật khẩu',
            'password-rep.same' => 'Mật khẩu nhập lại không khớp',

            'referred_code.exists'  => 'Mã giới thiệu không hợp lệ',
            'referred_code.max'     => 'Mã giới thiệu không được vượt quá :max ký tự',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->responseErrors('Gửi yêu cầu thất bại!', $validator->errors());
        }

        DB::beginTransaction();
        try {
            $customer = new Customer();
            $customer->fullname = $request->fullname;
            $customer->email = $request->email;

            if($request->referred_code){
                $referred = Customer::query()->where('code', $request->referred_code)->first();
                $customer->referred_id = $referred->id;
            }

            $customer->password = bcrypt($request->password);
            $customer->status = 1;

            $customer->save();

            $customer->code = $customer->generateUniqueCode();
            $customer->save();

            $request->session()->regenerate();

            auth()->guard('customer')->login($customer);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký tài khoản thành công!',
                'redirect_url' => route('front.home-page'),
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
        }

    }


}
