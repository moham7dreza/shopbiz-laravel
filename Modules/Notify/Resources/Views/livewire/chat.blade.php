<section>
    <a class="btn btn-sm course-scroll-button" data-bs-toggle="offcanvas" href="#offcanvasChat" role="button"
       aria-controls="offcanvasChat" title="چت روم">
        <i class="fa fa-comments"></i>
    </a>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasChat"
         aria-labelledby="offcanvasChatLabel">
        <nav class="navbar navbar-light bg-green-light p-3">
            <section class="d-flex gap-3">
                <section>
                    <img class="header-avatar" src="{{ $admin->profile() }}" alt="{{ $admin->fullName }}"
                         title="{{ $admin->fullName }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    {{--                                <span class="header-username">{{ $admin->fullName }}</span>--}}
                </section>
                <section class="d-flex flex-column justify-content-evenly">
                    <h5>مجموعه شاپ بیز</h5>
                    <p>در خدمتیم</p>
                </section>
            </section>
            <button type="button" class="btn-close text-reset align-self-start" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </nav>

        {{--        <div class="offcanvas-header">--}}
        {{--            <h5 class="offcanvas-title fw-bolder" id="offcanvasChatLabel">گفتوگو</h5>--}}
        {{--            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>--}}
        {{--        </div>--}}
        <div class="offcanvas-body chat-bg">
            @foreach($messages as $message)
                <section class="card position-relative rounded-3">
                    <section
                        class="card-header bg-blue-light d-flex justify-content-between align-items-center">
                        <section>{{ $admin->fullName }}</section>
                        <small
                            class="font-weight-bold chat-date text-muted">{{ jalaliDate($admin->created_at, "%A, %d %B %Y _ H:i:s") }}</small>
                    </section>
                    <section class="card-body">
                        <p class="card-text ms-3">
                            {{ $message }}
                        </p>
                    </section>
                    <section class="chat-user">
                        <img class="header-avatar" src="{{ $admin->profile() }}" alt="{{ $admin->fullName }}"
                             title="{{ $admin->fullName }}" data-bs-toggle="tooltip" data-bs-placement="top">
                        {{--                                <span class="header-username">{{ $admin->fullName }}</span>--}}
                    </section>
                </section>
            @endforeach

            <section class="border-top chat-msg-bar">
                <form method="post" wire:submit.prevent="sendMsg">
                    @csrf
                    <section class="row">
                        @php $message = $message ?? null @endphp
                        <x-panel-input wire:model="message" col="12" name="message" label="پیام" :message="$message" placeholder="پیام خود را بنویسید ..."/>
                        <x-panel-button col="12" title="ارسال پیام" loc="home" align="end" color="primary"/>
                    </section>
                </form>
            </section>
        </div>
    </div>
</section>
