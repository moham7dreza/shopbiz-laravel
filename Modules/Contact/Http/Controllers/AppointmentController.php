<?php

namespace Modules\Contact\Http\Controllers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Repositories\ContactRepoEloquentInterface;
use Modules\Contact\Services\ContactService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class AppointmentController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'appointment.index';

    public ContactRepoEloquentInterface $repo;
    public ContactService $service;

    /**
     * @param ContactRepoEloquentInterface $repo
     * @param ContactService $service
     */
    public function __construct(ContactRepoEloquentInterface $repo, ContactService $service)
    {
        $this->repo = $repo;
        $this->service = $service;

        $this->middleware('can:' . Permission::PERMISSION_APPOINTMENTS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_APPOINTMENT_SHOW)->only(['show']);
        $this->middleware('can:' . Permission::PERMISSION_APPOINTMENT_APPROVED)->only(['approved']);
        $this->middleware('can:' . Permission::PERMISSION_APPOINTMENT_STATUS)->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        $unReadAppointments = $this->repo->getUnReadAppointments();
        $this->service->makeReadContacts($unReadAppointments);
        if (isset(request()->search)) {
            $appointments = $this->repo->search(request()->search, 'appointment')->paginate(10);
            if (count($appointments) > 0) {
                $this->showToastOfFetchedRecordsCount(count($appointments));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $appointments = $this->repo->sort(request()->sort, request()->dir, 'appointment')->paginate(10);
            if (count($appointments) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $appointments = $this->repo->getLatestAppointments()->paginate(10);
        }

        return view('Contact::admin.appointment.index', compact(['appointments']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $appointment
     * @return Application|Factory|View
     */
    public function show(Contact $appointment): View|Factory|Application
    {
        return view('Contact::admin.appointment.show', compact(['appointment']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(403);
    }


    /**
     * @param Contact $appointment
     * @return JsonResponse
     */
    public function status(Contact $appointment): JsonResponse
    {
        return ShareService::changeStatus($appointment);
    }

    /**
     * @param Contact $appointment
     * @return RedirectResponse
     */
    public function approved(Contact $appointment): RedirectResponse
    {
        $result = $this->service->approveContact($appointment);
        if ($result) {
            return $this->showMessageWithRedirectRoute('وضعیت ملاقات با موفقیت تغییر کرد');
        } else {
            return $this->showMessageWithRedirectRoute('تایید ملاقات با خطا مواجه شد', 'خطا', status: 'error');
        }
    }

    /**
     * @param ContactRequest $request
     * @param Contact $appointment
     * @return RedirectResponse
     */
    public function answer(ContactRequest $request, Contact $appointment): RedirectResponse
    {
        dd(1);
        // TODO
    }
}
