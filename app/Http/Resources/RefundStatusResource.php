<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefundStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "APIConnect"    => $this->APIConnect,
            "bank_tran_id"  => $this->bank_tran_id,
            "tran_id"       => $this->tran_id,
            "initiated_on"  => $this->initiated_on,
            "refunded_on"   => $this->refunded_on,
            "status"        => $this->status,
            "refund_ref_id" => $this->refund_ref_id,
        ];
    }
}
