<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function login(Request $request) {

        $code = $request->input('code');

        if(!$code) {
            return json_encode('Aucun code renseigné');
        }
        
        return json_encode($request->input('code'));
        
    }
}
