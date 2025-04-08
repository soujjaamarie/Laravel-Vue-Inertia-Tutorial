<?php

namespace App\Http\Resources;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'class' => ClassesResources::make($this->whenLoaded('class')),
            'section' => SectionsResources::make($this->whenLoaded('section')),
           

              
        ];
    }
    
}
