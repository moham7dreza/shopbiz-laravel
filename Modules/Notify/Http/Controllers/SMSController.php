<?php

namespace Modules\Notify\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Notify\Entities\SMS;
use Modules\Notify\Http\Requests\SMSRequest;
use Modules\Share\Http\Controllers\Controller;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $sms = SMS::query()->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('Notify::sms.index', compact('sms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('Notify::sms.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SMSRequest $request
     * @return RedirectResponse
     */
    public function store(SMSRequest $request): RedirectResponse
    {
        $inputs = $request->all();

        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $sms = SMS::query()->create($inputs);
        return redirect()->route('sms-notify.index')->with('swal-success', 'پیامک شما با موفقیت ثبت شد');
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
     * @param SMS $sms
     * @return Application|Factory|View
     */
    public function edit(SMS $sms)
    {
        return view('Notify::sms.edit', compact('sms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SMSRequest $request
     * @param SMS $sms
     * @return RedirectResponse
     */
    public function update(SMSRequest $request, SMS $sms): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $sms->update($inputs);
        return redirect()->route('sms-notify.index')->with('swal-success', 'پیامک شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SMS $sms
     * @return RedirectResponse
     */
    public function destroy(SMS $sms): RedirectResponse
    {
        $result = $sms->delete();
        return redirect()->route('sms-notify.index')->with('swal-success', 'پیامک شما با موفقیت حذف شد');
    }


    /**
     * @param SMS $sms
     * @return JsonResponse
     */
    public function status(SMS $sms): JsonResponse
    {

        $sms->status = $sms->status == 0 ? 1 : 0;
        $result = $sms->save();
        if($result){
                if($sms->status == 0){
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
