<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FordisController extends Controller
{
    public function index()
    {
        return view('fordis.fordis');
    }
}
