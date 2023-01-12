<?php

use Illuminate\Support\Facades\Route;
use Modules\Ticket\Http\Controllers\TicketAdminController;
use Modules\Ticket\Http\Controllers\TicketCategoryController;
use Modules\Ticket\Http\Controllers\TicketController;
use Modules\Ticket\Http\Controllers\TicketPriorityController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('ticketCategory', 'TicketCategoryController', ['except' => 'show']);
    //category
    Route::prefix('ticketCategory')->group(function () {
        Route::get('/status/{ticketCategory}', [TicketCategoryController::class, 'status'])->name('ticketCategory.status');
    });

    $router->resource('ticketPriority', 'TicketPriorityController', ['except' => 'show']);
    Route::prefix('ticketPriority')->group(function () {
        Route::get('/status/{ticketPriority}', [TicketPriorityController::class, 'status'])->name('ticketPriority.status');
    });

    //admin
    Route::prefix('adminTicket')->group(function () {
        Route::get('/', [TicketAdminController::class, 'index'])->name('ticket-admin.index');
        Route::get('/set/{admin}', [TicketAdminController::class, 'set'])->name('ticket-admin.set');
    });

    Route::prefix('ticket')->group(function () {
        //main
        Route::get('/', [TicketController::class, 'index'])->name('ticket.index');
        Route::get('/new-tickets', [TicketController::class, 'newTickets'])->name('ticket.newTickets');
        Route::get('/open-tickets', [TicketController::class, 'openTickets'])->name('ticket.openTickets');
        Route::get('/close-tickets', [TicketController::class, 'closeTickets'])->name('ticket.closeTickets');
        Route::get('/show/{ticket}', [TicketController::class, 'show'])->name('ticket.show');
        Route::post('/answer/{ticket}', [TicketController::class, 'answer'])->name('ticket.answer');
        Route::get('/change/{ticket}', [TicketController::class, 'change'])->name('ticket.change');
    });
});
