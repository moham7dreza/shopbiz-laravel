<?php

namespace Modules\Contact\Http\Controllers;
use Modules\ACL\Entities\Permission;
use Modules\Contact\Repositories\ContactRepoEloquentInterface;
use Modules\Contact\Services\ContactService;
use Modules\Share\Http\Controllers\Controller;
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
}
