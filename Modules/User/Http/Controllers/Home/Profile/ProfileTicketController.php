<?php

namespace Modules\User\Http\Controllers\Home\Profile;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketFile;
use Modules\Ticket\Repositories\TicketCategory\TicketCategoryRepoEloquentInterface;
use Modules\Ticket\Repositories\TicketPriority\TicketPriorityRepoEloquentInterface;
use Modules\Ticket\Services\Ticket\TicketServiceInterface;
use Modules\Ticket\Services\TicketFile\TicketFileServiceInterface;
use Modules\User\Http\Requests\Home\StoreTicketRequest;
use Modules\User\Repositories\UserRepoEloquentInterface;

class ProfileTicketController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public TicketServiceInterface $ticketService;

    /**
     * @param TicketServiceInterface $ticketService
     */
    public function __construct(TicketServiceInterface $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $tickets = auth()->user()->tickets()->whereNull('ticket_id')->paginate(5);

        return view('User::home.profile.ticket.index', compact('tickets'));
    }

    /**
     * @param Ticket $ticket
     * @return Factory|View|Application
     */
    public function show(Ticket $ticket): Factory|View|Application
    {
        return view('User::home.profile.ticket.show', compact('ticket'));
    }

    /**
     * @param StoreTicketRequest $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function answer(StoreTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->ticketService->store($request, $ticket, 'user');
        return $this->showAlertWithRedirect('پاسخ شما با موفقیت ثبت شد');
    }


    /**
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function change(Ticket $ticket): RedirectResponse
    {
        $this->ticketService->changeTicketStatus($ticket);
        return $this->showAlertWithRedirect('تغییر شما با موفقیت ثبت شد');
    }

    /**
     * @param TicketCategoryRepoEloquentInterface $ticketCategoryRepo
     * @param TicketPriorityRepoEloquentInterface $ticketPriorityRepo
     * @return Application|Factory|View
     */
    public function create(TicketCategoryRepoEloquentInterface $ticketCategoryRepo, TicketPriorityRepoEloquentInterface $ticketPriorityRepo): View|Factory|Application
    {
        $ticketCategories = $ticketCategoryRepo->index()->active()->get();
        $ticketPriorities = $ticketPriorityRepo->index()->active()->get();
        return view('User::home.profile.ticket.create', compact(['ticketCategories', 'ticketPriorities']));
    }

    /**
     * @param StoreTicketRequest $request
     * @param TicketFileServiceInterface $ticketFileService
     * @param UserRepoEloquentInterface $userRepo
     * @return RedirectResponse
     */
    public function store(StoreTicketRequest $request, TicketFileServiceInterface $ticketFileService, UserRepoEloquentInterface $userRepo): RedirectResponse
    {
        DB::transaction(function () use ($request, $ticketFileService, $userRepo) {
            $ticket = $this->ticketService->store($request);
            if ($request->hasFile('file')) {
                $request->ticket_id = $ticket->id;
                $request->status = TicketFile::STATUS_ACTIVE;
                $result = $ticketFileService->store($request);
                if ($result == 'upload failed') {
                    return $this->showAlertWithRedirect(message: 'آپلود فایل با خطا مواجه شد', title: 'خطا', type: 'error', route: 'customer.profile.my-tickets');
                }
            }
            $adminUser = $userRepo->findSystemAdmin();
            $this->ticketService->sendTicketCreatedNotificationToAdmin($adminUser, $ticket->id);
        });

        return $this->showAlertWithRedirect('تیکت شما با موفقیت ثبت شد', route: 'customer.profile.my-tickets');
    }
}
