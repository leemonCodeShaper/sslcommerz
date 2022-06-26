<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderValidationRequest;
use App\Http\Requests\PayRequest;
use App\Http\Requests\RefundRequest;
use App\Http\Requests\TransactionQueryRequest;
use App\Http\Resources\PayResource;
use App\Http\Resources\RefudnResource;
use App\Http\Resources\RefundStatusResource;
use App\Http\Resources\TransactionQueryResource;
use App\Models\Payment;
use DGvai\SSLCommerz\SSLCommerz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @return void
     */
    public function success(Request $request)
    {
        $validate = $this->orderValidation(new OrderValidationRequest($request->all()));
        if ($validate) {
            $bankID = $request->bank_tran_id;   //  KEEP THIS bank_tran_id FOR REFUNDING ISSUE

            //  Do the rest database saving works
            //  take a look at dd($request->all()) to see what you need
            return response()->json($request);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    public function failure(Request $request)
    {
        //  do the database works
        //  also same goes for cancel()
        //  for IPN() you can leave it untouched or can follow
        //  official documentation about IPN from SSLCommerz Panel
    }

    /**
     * @param Request $request
     * @return void
     */
    public function cancel(Request $request)
    {

    }

    /**
     * @param Request $request
     * @return void
     */
    public function pay(PayRequest $request)
    {
        //  DO YOU ORDER SAVING PROCESS TO DB OR ANYTHING
        $sandbox_api = env('SANDBOX_PAY_API_URL');
        $live_api = env('LIVE_PAY_API_URL');

        $data = [
            'store_id'     => env('SSLC_STORE_ID'),
            'store_passwd' => env('SSLC_STORE_PASSWORD'),
            'total_amount' => $request->totalAmount,
            'currency'     => $request->currency,
            'tran_id'      => time() . rand(),
            'success_url'  => route(env('SSLC_ROUTE_SUCCESS')),
            'fail_url'     => route(env('SSLC_ROUTE_FAILURE')),
            'cancel_url'   => route(env('SSLC_ROUTE_CANCEL')),

            'emi_option' => $request->emiOption,

            'cus_name'     => $request->cusName,
            'cus_email'    => $request->cusEmail,
            'cus_add1'     => $request->cusAddress,
            'cus_city'     => $request->cusCity,
            "cus_postcode" => $request->cusPostCode,
            'cus_country'  => $request->cusCountry,
            'cus_phone'    => $request->cusPhone,

            'shipping_method' => $request->shippingMethod,
            'num_of_item'     => $request->numOfItems,

            'product_name'     => $request->productName,
            'product_category' => $request->productCategory,
            'product_profile'  => $request->productProfile,
        ];
        $response = Http::asForm()->post($sandbox_api, $data);

        if ($response->successful()) {
            $data = json_decode($response);
            return new PayResource($data);
        } else {
            return response()->json(['error' => $response->body()]);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    public function refund(RefundRequest $request)
    {
        $sandbox_api = env('SANDBOX_REFUND_API_URL');
        $live_api = env('LIVE_REFUND_API_URL');

        $response = Http::get($sandbox_api, [
            'bank_tran_id'   => $request->bankTranId,
            'store_id'       => env('SSLC_STORE_ID'),
            'store_passwd'   => env('SSLC_STORE_PASSWORD'),
            'refund_amount'  => $request->refundAmount,
            'refund_remarks' => $request->refundRemarks,
        ]);

        if ($response->successful()) {
            $data = json_decode($response);
            return new RefudnResource($data);
        } else {
            return response()->json(['error' => $response->body()]);
        }
    }

    public function refundStatus(Request $request)
    {
        $sandbox_api = env('SANDBOX_REFUND_STATUS_API_URL');
        $live_api = env('LIVE_REFUND_STATUS_API_URL');

        $response = Http::get($sandbox_api, [
            'refund_ref_id' => $request->refundRefId,
            'store_id'      => env('SSLC_STORE_ID'),
            'store_passwd'  => env('SSLC_STORE_PASSWORD'),
        ]);

        if ($response->successful()) {
            $data = json_decode($response);
            return new RefundStatusResource($data);
        } else {
            return response()->json(['error' => $response->body()]);
        }
    }

    public function transactionQuery(TransactionQueryRequest $request)
    {
        $sandbox_api = env('SANDBOX_TRANSACTION_QUERY_API_URL');
        $live = env('LIVE_TRANSACTION_QUERY_API_URL');

        $response = Http::get($sandbox_api, [
            'tran_id'      => $request->tranId,
            'store_id'     => env('SSLC_STORE_ID'),
            'store_passwd' => env('SSLC_STORE_PASSWORD'),
        ]);

        if ($response->successful()) {
            $data = json_decode($response);
            return new TransactionQueryResource($data);
        } else {
            return response()->json(['error' => $response->body()]);
        }

    }

    /**
     * @param Request $request
     * @return void
     */
    public function ipn(Request $request)
    {

    }

    public function orderValidation(OrderValidationRequest $request)
    {
        $sandbox_api = env('SANDBOX_ORDER_VALIDATION_API_URL');
        $live_api = env('LIVE_ORDER_VALIDATION_API_URL');

        $response = Http::get($sandbox_api, [
            'val_id'       => $request->val_id,
            'store_id'     => env('SSLC_STORE_ID'),
            'store_passwd' => env('SSLC_STORE_PASSWORD'),
        ]);

        if ($response->successful()) {
            $data = json_decode($response);

            // status validation
            if ($data->status == 'VALID' || $data->status == 'VALIDATED') {
                // transaction id validation with database for extra security
                // amount validation with database for extra security
                // currency validation with database for extra security
                // currency_amount with database for extra security

                return true;
            }

        } else {
            return response()->json(['error' => $response->body()]);
        }
    }
}
