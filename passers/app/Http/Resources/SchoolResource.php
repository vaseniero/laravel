<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * 
         * return parent::toArray($request);
        */
        return [
            'school'    => $this->school,
            'passers'   => $this->passers
        ];
    }
}
