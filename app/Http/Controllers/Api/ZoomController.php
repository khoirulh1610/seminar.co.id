<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallbackZoom;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    public function index(Request $request)
    {
        $data = file_get_contents("php://input");
        if($data){
            $z    = new CallbackZoom();
            $z->data = $data;
            $z->save();
        }
        
    }
}
