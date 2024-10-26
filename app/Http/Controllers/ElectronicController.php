<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElectronicController extends Controller
{
    public function index()
    {
        return view('.index');
    }

    public function create()
    {
        return view('.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit($id)
    {
        return view('.edit');
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
    }

    public function destroy($id)
    {
        //
    }

}
