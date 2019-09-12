<?php

namespace App\Http\Controllers;
use App\Libraries\ApiValidations;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->validator = new ApiValidations();
    }

    public function create(Request $request)
    {
        $validation = $this->validator->create_voucher($request->all());

        if($validation['status']){
            $voucher = new Voucher([
                'percentage' => $request->input('percentage'),
                'code' => Str::random(10),
                'user_id' => $request->input('user_id'),
                'group_id' => $request->input('group_id'),
                'status' => 'active'
            ]);
            $voucher->save();

            $vouch = new Voucher();
            $response = $vouch->with(['group','user'])->where(['status' => 'active', 'id' => $voucher->id])->first();
            return response()->json([
                'status'    =>  true,
                'message'   => 'Thanks! your Discount Voucher has been successfully created.',
                'response'  => $response
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function get_vouchers(Request $request){
        $validation = $this->validator->voucher($request->all());

        if($validation['status']){
            $vouch = new Voucher();
            $response = $vouch->with(['group','user'])->where(['status' => 'active'])->get();
            return response()->json([
                'status'    =>  true,
                'message'   => 'Discount Voucher Lists Fetched successfully',
                'response'  => $response
            ], 200);
        }else{
            return response()->json($validation);
        }
    }

    public function delete_voucher(Request $request){
        $validation = $this->validator->delete_voucher($request->all());

        if($validation['status']){
            $vouch = new Voucher();
            $response = $vouch->where(['id' => $request->input('voucher_id')])->update(['status' => 'de-active']);
            return response()->json([
                'status'    =>  true,
                'message'   => 'Discount Voucher Deleted successfully',
            ], 200);
        }else{
            return response()->json($validation);
        }
    }
}
