<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use DGvai\SSLCommerz\SSLCommerz;
use Illuminate\Http\Request;

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
    public function order(Request $request)
    {
        //  DO YOU ORDER SAVING PROCESS TO DB OR ANYTHING

        $sslc = new SSLCommerz();
        $sslc->amount($request->productPrice)
            ->trxid(time().rand())
            ->product($request->productName)
            ->customer($request->customerName, $request->customerEmail);

        $data =  json_decode($sslc->make_payment(true));
        return response()->json($data);

        /**
         *
         *  USE:  $sslc->make_payment(true) FOR CHECKOUT INTEGRATION
         *
         * */
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
