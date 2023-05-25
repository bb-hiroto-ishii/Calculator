<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

class CalcController extends Controller
{
    public function jvscalc()
    {

        return view('jvscalc');
    }
    
}