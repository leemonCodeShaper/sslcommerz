<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefudnResource extends JsonResource
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
            "trans_id"      => $this->trans_id,
            "refund_ref_id" => $this->refund_ref_id,
            "status"        => $this->status,
            "errorReason"   => $this->errorReason
        ];
    }
}
