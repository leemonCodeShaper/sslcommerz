<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayRequest;
use App\Http\Requests\RefundRequest;
use App\Http\Requests\TransactionQueryRequest;
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
        $validate = SSLCommerz::validate_payment($request);
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

        $response = Http::get($sandbox_api, [
            'bank_tran_id'   => $request->bankTranId,
            'store_id'       => env('SSLC_STORE_ID'),
            'store_passwd'   => env('SSLC_STORE_PASSWORD'),
            'refund_amount'  => $request->refundAmount,
            'refund_remarks' => $request->refundRemarks,
        ]);


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
            'tran_id' => $request->tranId,
            'store_id'      => env('SSLC_STORE_ID'),
            'store_passwd'  => env('SSLC_STORE_PASSWORD'),
        ]);

        if($response->successful()) {
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
