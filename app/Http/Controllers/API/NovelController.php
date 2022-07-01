<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function index(){
        return Novel::with(['chapters','categories'])->get();
    }
}
