<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('backend.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $data = [
            'name' => $request->name,
        ];

        $is_permissions_created = Permission::create($data);

        if ($is_permissions_created) {
            return redirect()->back()->with('success', 'Permission created successfully');
        } else {
            return redirect()->back()->with('error', 'Permission has failed to create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('backend.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id.',id',
        ]);
        $data = [
            'name' => $request->name,
        ];

        $is_permissions_updated = Permission::find($permission->id)->update($data);

        if ($is_permissions_updated) {
            return redirect()->back()->with('success', 'Permission updated successfully');
        } else {
            return redirect()->back()->with('error', 'Permission has failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $is_permissions_deleted = Permission::find($permission->id)->delete();


        if ($is_permissions_deleted) {
            return redirect()->back()->with('success', 'Permission deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Permission has failed to delete');
        }
    }
}
