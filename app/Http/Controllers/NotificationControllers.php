<?php

namespace App\Http\Controllers;

use App\Models\Notification;

use Illuminate\Http\Request;

class NotificationControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // RETURN ALL NotificationS
        return Notification::all();
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
        $request->validate([]);
        return Notification::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find by id
        return Notification::find($id);
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
        $value = Notification::find($id);
        $value->update($request->all());
        return $value;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete one data by id
        return Notification::destroy($id);
    }
}
