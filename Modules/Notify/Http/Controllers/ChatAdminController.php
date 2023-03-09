<?php

namespace Modules\Notify\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\Notify\Entities\ChatAdmin;
use Modules\Notify\Repositories\ChatAdmin\ChatAdminRepoEloquentInterface;
use Modules\Notify\Services\ChatAdmin\ChatAdminService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepoEloquentInterface;

class ChatAdminController extends Controller
{
    use ShowMessageWithRedirectTrait;
    /**
     * @var string
     */
    private string $redirectRoute = 'chat-admin.index';

    /**
     * @var string
     */
    private string $class = ChatAdmin::class;

    public ChatAdminRepoEloquentInterface $repo;
    public ChatAdminService $service;

    /**
     * @param ChatAdminRepoEloquentInterface $repo
     * @param ChatAdminService $service
     */
    public function __construct(ChatAdminRepoEloquentInterface $repo, ChatAdminService $service)
    {
        $this->repo = $repo;
        $this->service = $service;

//        $this->middleware('can:'. Permission::PERMISSION_ADMIN_TICKETS)->only(['index']);
//        $this->middleware('can:'. Permission::PERMISSION_ADMIN_TICKET_ADD)->only(['set']);
    }

    public function index(UserRepoEloquentInterface $userRepo)
    {
        if (isset(request()->search)) {
            $admins = $userRepo->search(request()->search)->paginate(10);
            if (count($admins) > 0) {
                $this->showToastOfFetchedRecordsCount(count($admins));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $admins = $userRepo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($admins) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $admins = $userRepo->adminUsers()->paginate(10);
        }
        return view('Notify::chat.admin.index', compact(['admins']));
    }


    /**
     * @param User $admin
     * @return RedirectResponse
     */
    public function set(User $admin): RedirectResponse
    {
        $this->service->addOrRemoveFromChatAdmin($admin);
        return $this->showMessageWithRedirectRoute('تغییر شما با موفقیت ثبت شد');
    }
}
