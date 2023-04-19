<?php

namespace App\Http\Controllers;

use App\Models\Bank_Employee;

use Illuminate\Http\Request;

class BankEmployeeControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // RETURN ALL BANKS
        return Bank_Employee::all();
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
            'username' => 'required',
            'password' => 'required',
            'client_permission' => 'required',
            'user_permission' => 'required',
            'bank_id' => 'required',
            'employee_id' => 'required',
            'role' => 'required',
        ]);
        return Bank_Employee::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find by id
        return Bank_Employee::find($id);
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
        $value = Bank_Employee::find($id);
        $value->update($request->all());
        return $value;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete one data by id
        return Bank_Employee::destroy($id);
    }
}
