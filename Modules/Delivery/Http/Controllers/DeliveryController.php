<?php

namespace Modules\Delivery\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Delivery\Entities\Delivery;
use Modules\Share\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $delivery_methods = Delivery::all();
        return view('Delivery::index', compact('delivery_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.market.delivery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryRequest $request)
    {
        $inputs = $request->all();
        $delivery = Delivery::create($inputs);
        return redirect()->route('admin.market.delivery.index')->with('swal-success', 'روش ارسال جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        return view('admin.market.delivery.edit', compact('delivery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryRequest $request, Delivery $delivery)
    {
        $inputs = $request->all();
        $delivery->update($inputs);
        return redirect()->route('admin.market.delivery.index')->with('swal-success', 'روش ارسال شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        $result = $delivery->delete();
       return redirect()->route('admin.market.delivery.index')->with('swal-success', 'روش ارسال شما با موفقیت حذف شد');
    }


    public function status(Delivery $delivery){

        $delivery->status = $delivery->status == 0 ? 1 : 0;
        $result = $delivery->save();
        if($result){
                if($delivery->status == 0){
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
