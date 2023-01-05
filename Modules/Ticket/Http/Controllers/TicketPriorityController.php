<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Share\Http\Controllers\Controller;
use Modules\Ticket\Entities\TicketPriority;

class TicketPriorityController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $ticketPriorities = TicketPriority::all();
        return view('Ticket::priority.index', compact('ticketPriorities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ticket.priority.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketPriorityRequest $request)
    {
        $inputs = $request->all();
        $ticketPriority = TicketPriority::create($inputs);
        return redirect()->route('admin.ticket.priority.index')->with('swal-success', 'اولویت  جدید شما با موفقیت ثبت شد');
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
    public function edit(TicketPriority $ticketPriority)
    {
        return view('admin.ticket.priority.edit', compact('ticketPriority'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketPriorityRequest $request, TicketPriority $ticketPriority)
    {
        $inputs = $request->all();
        $ticketPriority->update($inputs);
        return redirect()->route('admin.ticket.priority.index')->with('swal-success', 'اولویت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketPriority $ticketPriority)
    {
        $result = $ticketPriority->delete();
        return redirect()->route('admin.ticket.priority.index')->with('swal-success', 'اولویت شما با موفقیت حذف شد');
    }



    public function status(TicketPriority $ticketPriority){

        $ticketPriority->status = $ticketPriority->status == 0 ? 1 : 0;
        $result = $ticketPriority->save();
        if($result){
                if($ticketPriority->status == 0){
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
