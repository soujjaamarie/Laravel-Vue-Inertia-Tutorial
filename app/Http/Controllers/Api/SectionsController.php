<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListSectionsRequest;
use App\Http\Resources\SectionsResources;
use App\Models\Sections;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    public function __invoke(ListSectionsRequest $request)
    {
        
        $section = Sections::where('class_id', $request->class_id)->get();
        
        return SectionsResources::collection($section);
    }
    
}
