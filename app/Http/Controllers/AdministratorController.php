<?php

namespace App\Http\Controllers;

use App\Models\Administrators;
use Illuminate\Http\Request;


class AdministratorController extends Controller 
{
    public function index()
    {
        $administrator = Administrators::all();
        return view('super-admin.administrators', compact('administrator'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);
        Administrators::create($validated);
        return redirect()->route('administrators.index')->with('success', 'Principal added successfully!');
    }

    public function update(Request $request, $id)
    {
        $administrator = Administrators::findOrFail($id);
        $administrator->update($request->all());
        return redirect()->route('administrators.index')->with('success', 'Administrator updated successfully');
    }
        public function destroy($id)
    {
        $administrator = Administrators::findOrFail($id);
        $administrator->delete();
        return redirect()->route('administrators.index')->with('success', 'Administrator deleted successfully');
    }

}