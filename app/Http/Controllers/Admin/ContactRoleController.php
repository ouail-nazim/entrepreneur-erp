<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRoleRequest;
use App\Http\Requests\UpdateContactRoleRequest;
use App\Models\ContactRole;

class ContactRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = ContactRole::paginate(10);
        return view('admin.contact_roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact_roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRoleRequest $request)
    {
        ContactRole::create($request->validated());
        return redirect()->route('contact_roles.index')->with('success', __('contact_roles.created_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactRole $contactRole)
    {
        return view('admin.contact_roles.show', compact('contactRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactRole $contactRole)
    {
        return view('admin.contact_roles.edit', compact('contactRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRoleRequest $request, ContactRole $contactRole)
    {
        $contactRole->update($request->validated());
        return redirect()->route('contact_roles.index')->with('success', __('contact_roles.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactRole $contactRole)
    {
        $contactRole->delete();
        return redirect()->route('contact_roles.index')->with('success', __('contact_roles.deleted_success'));
    }
}
