<section>
    <a class="btn btn-sm course-scroll-button" data-bs-toggle="offcanvas" href="#offcanvasChat" role="button" aria-controls="offcanvasChat" title="چت روم">
        <i class="fa fa-comments"></i>
    </a>
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasChat" aria-labelledby="offcanvasChatLabel">
        <nav class="navbar navbar-light bg-green-light p-3">
                        <section class="d-flex gap-3">
                            <section>
                                <img class="header-avatar" src="{{ auth()->user()->profile() }}" alt="{{ auth()->user()->fullName }}">
{{--                                <span class="header-username">{{ auth()->user()->fullName }}</span>--}}
                            </section>
                            <section class="d-flex flex-column justify-content-evenly">
                                <h5>مجموعه شاپ بیز</h5>
                                <p>در خدمتیم</p>
                            </section>
                        </section>
                        <button type="button" class="btn-close text-reset align-self-start" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </nav>

{{--        <div class="offcanvas-header">--}}
{{--            <h5 class="offcanvas-title fw-bolder" id="offcanvasChatLabel">گفتوگو</h5>--}}
{{--            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>--}}
{{--        </div>--}}
        <div class="offcanvas-body chat-bg">
            <section class="card">
                <section
                    class="card-header bg-blue-light d-flex justify-content-between align-items-center">
                    <small
                        class="font-weight-bold">{{ jalaliDate(auth()->user()->created_at, "%A, %d %B %Y _ H:i:s") }}</small>
                </section>
                <section class="card-body">
                    <p class="card-text">
                        {{ auth()->user()->fullName }}
                    </p>
                </section>
            </section>
            <section class="border-top chat-msg-bar">
                <form action="">
                    <x-panel-input name="message" col="12" label="" placeholder="پیام ..."/>
                </form>
            </section>
        </div>
    </div>
</section>
