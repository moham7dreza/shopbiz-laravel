<?php

namespace Modules\Menu\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Http\Requests\MenuRequest;
use Modules\Share\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $menus = Menu::query()->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('Menu::index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $menus = Menu::query()->where('parent_id', null)->get();
        return view('Menu::create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuRequest $request
     * @return RedirectResponse
     */
    public function store(MenuRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $menu = Menu::query()->create($inputs);
        return redirect()->route('Menu::index')->with('swal-success', 'منوی  جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id): Response
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Menu $menu
     * @return Application|Factory|View
     */
    public function edit(Menu $menu)
    {
        $parent_menus = Menu::query()->where('parent_id', null)->get()->except($menu->id);
        return view('Menu::edit', compact('menu' ,'parent_menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MenuRequest $request
     * @param Menu $menu
     * @return RedirectResponse
     */
    public function update(MenuRequest $request, Menu $menu): RedirectResponse
    {
        $inputs = $request->all();
        $menu->update($inputs);
        return redirect()->route('menu.index')->with('swal-success', 'منوی  شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return RedirectResponse
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        $result = $menu->delete();
        return redirect()->route('menu.index')->with('swal-success', ' منو شما با موفقیت حذف شد');
    }


    /**
     * @param Menu $menu
     * @return JsonResponse
     */
    public function status(Menu $menu): JsonResponse
    {

        $menu->status = $menu->status == 0 ? 1 : 0;
        $result = $menu->save();
        if($result){
                if($menu->status == 0){
                    return response()->json(['status' => true, 'checked' => false]);
                }
                else{
                    return response()->json(['status' => true, 'checked' => true]);
                }
        }
        else{
            return response()->json(['status' => false]);
        }

    }
}
