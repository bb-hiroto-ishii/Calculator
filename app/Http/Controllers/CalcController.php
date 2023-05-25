<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

class CalcController extends Controller
{
    public function calculator(Request $req)
    {
        $dsp = $req->name;
        $j_in = $req->var0;
        $dsp_old = $req->var1;
        $j_dp = $req->var2;
        $j_op = $req->var3;
        $len = $req->var4;
        return view('calculator',compact('dsp','j_in','dsp_old','j_dp','j_op','len'));
    }
    
    public function result(Request $req)
    {
        $dsp = $req->name;
        return view('result',compact('dsp'));
    }
}