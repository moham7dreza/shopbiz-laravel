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

class ContactController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'contact.index';

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

        $this->middleware('can:' . Permission::PERMISSION_CONTACTS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_CONTACT_SHOW)->only(['show']);
        $this->middleware('can:' . Permission::PERMISSION_CONTACT_APPROVED)->only(['approved']);
        $this->middleware('can:' . Permission::PERMISSION_CONTACT_STATUS)->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        $unReadContacts = $this->repo->getUnReadContacts();
        $this->service->makeReadContacts($unReadContacts);
        if (isset(request()->search)) {
            $contacts = $this->repo->search(request()->search)->paginate(10);
            if (count($contacts) > 0) {
                $this->showToastOfFetchedRecordsCount(count($contacts));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $contacts = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($contacts) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $contacts = $this->repo->getLatestContacts()->paginate(10);
        }

        return view('Contact::admin.contact.index', compact(['contacts']));
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
     * @param Contact $contact
     * @return Application|Factory|View
     */
    public function show(Contact $contact): View|Factory|Application
    {
        return view('Contact::admin.contact.show', compact(['contact']));
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
     * @param Contact $contact
     * @return JsonResponse
     */
    public function status(Contact $contact): JsonResponse
    {
        return ShareService::changeStatus($contact);
    }

    /**
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function approved(Contact $contact): RedirectResponse
    {
        $result = $this->service->approveContact($contact);
        if ($result) {
            return $this->showMessageWithRedirectRoute('وضعیت فرم با موفقیت تغییر کرد');
        } else {
            return $this->showMessageWithRedirectRoute('تایید فرم با خطا مواجه شد', 'خطا', status: 'error');
        }
    }

    /**
     * @param ContactRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function answer(ContactRequest $request, Contact $contact): RedirectResponse
    {
        dd(1);
        // TODO
    }
}
