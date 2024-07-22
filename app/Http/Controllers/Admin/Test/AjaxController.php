<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\T_user;

class AjaxController extends Controller
{
    public function id(Request $request) {
        $id = $request->id;
        $user = T_user::where('id',$id)->first();

        header('Content-type: application/json');
        echo json_encode($user,JSON_UNESCAPED_UNICODE);
    }
}
