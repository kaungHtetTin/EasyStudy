<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        return view('student.reports',[
            'page_title'=>'Report History',
        ]);
    }

    public function create(){
        
    }

    public function show($id){
        return $id;
    }
}
