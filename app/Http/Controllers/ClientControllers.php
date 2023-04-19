<?php

namespace App\Http\Controllers;

use App\Models\Client;

use Illuminate\Http\Request;

class ClientControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // RETURN ALL BANKS
        return Client::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // this is to validate required field
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'password' => 'required',
            'user_permission' => 'required',
            'client_id' => 'required',
            'merchant_id' => 'required',
        ]);
        return Client::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find by id
        return Client::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //update by Id
        $value = Client::find($id);
        $value->update($request->all());
        return $value;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete one data by id
        return Client::destroy($id);
    }
}
