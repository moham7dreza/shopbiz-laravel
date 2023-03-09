<?php

namespace Modules\Notify\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Notify\Entities\Chat;
use Modules\Notify\Http\Requests\StoreChatRequest;
use Modules\Notify\Repositories\Chat\ChatRepoEloquentInterface;
use Modules\Notify\Services\Chat\ChatService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ChatController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'chat.index';

    /**
     * @var string
     */
    private string $class = Chat::class;

    public ChatRepoEloquentInterface $repo;
    public ChatService $service;

    /**
     * @param ChatRepoEloquentInterface $emailRepoEloquent
     * @param ChatService $emailService
     */
    public function __construct(ChatRepoEloquentInterface $emailRepoEloquent, ChatService $emailService)
    {
        $this->repo = $emailRepoEloquent;
        $this->service = $emailService;

//        $this->middleware('can:' . Permission::PERMISSION_EMAIL_NOTIFYS)->only(['index']);
//        $this->middleware('can:' . Permission::PERMISSION_EMAIL_NOTIFY_CREATE)->only(['create', 'store']);
//        $this->middleware('can:' . Permission::PERMISSION_EMAIL_NOTIFY_EDIT)->only(['edit', 'update']);
//        $this->middleware('can:' . Permission::PERMISSION_EMAIL_NOTIFY_DELETE)->only(['destroy']);
//        $this->middleware('can:' . Permission::PERMISSION_EMAIL_NOTIFY_STATUS)->only(['status']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|RedirectResponse|Application
    {
        if (isset(request()->search)) {
            $chats = $this->repo->search(request()->search)->paginate(10);
            if (count($chats) > 0) {
                $this->showToastOfFetchedRecordsCount(count($chats));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $chats = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($chats) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            } else {
                $this->showToastOfNotDataExists();
            }
        } else {
            $chats = $this->repo->index()->paginate(10);
        }

        return view('Notify::chat.index', compact(['chats']));

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
     * @param Chat $chat
     * @return Application|Factory|View
     */
    public function show(Chat $chat): View|Factory|Application
    {
        return view('Notify::chat.show', compact(['chat']));
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
     * @param Chat $chat
     * @return JsonResponse
     */
    public function status(Chat $chat): JsonResponse
    {
        return ShareService::changeStatus($chat);
    }


    /**
     * @param StoreChatRequest $request
     * @param Chat $chat
     * @return RedirectResponse
     */
    public function answer(StoreChatRequest $request, Chat $chat): RedirectResponse
    {
        if (is_null($chat->parent)) {
            $this->service->replyComment($request, $productComment);
            $this->increaseCommentsCount($productComment);
            return $this->showMessageWithRedirectRoute('پاسخ شما با موفقیت ثبت شد');
        } else {
            return $this->showMessageWithRedirectRoute('با خطا مواجه شد', 'خطا', status: 'error');
        }
    }
}
