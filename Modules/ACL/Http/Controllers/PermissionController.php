<?php

namespace Modules\ACL\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Http\Requests\PermissionRequest;
use Modules\Share\Http\Controllers\Controller;

class PermissionController extends Controller
{
    private string $redirectRoute = 'permission.index';

    private string $class = Permission::class;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('ACL::permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('ACL::permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $inputs = $request->all();
        $permission = Permission::query()->create($inputs);
        return redirect()->route('permission.index')->with('swal-success', 'دسترسی جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return Application|Factory|View
     */
    public function edit(Permission $permission)
    {
        return view('ACL::permission.edit', compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    {
        $inputs = $request->all();
        $permission->update($inputs);
        return redirect()->route('permission.index')->with('swal-success', 'دسترسی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $result = $permission->delete();
        return redirect()->route('permission.index')->with('swal-success', 'دسترسی شما با موفقیت حذف شد');
    }
}
