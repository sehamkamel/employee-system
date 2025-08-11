<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('jobTitles')->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|string|max:255|unique:departments,name',
        'description' => 'nullable|string',
    ]);

    Department::create([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('departments.index')->with('success', 'Department added successfully!');
    }

    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, string $id)
    {
         $request->validate([
        'name' => 'required|string|max:255|unique:departments,name,' . $id,
        'description' => 'nullable|string',
    ]);

    $department = Department::findOrFail($id);
    $department->update([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
    }

    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully!');
    }
}


