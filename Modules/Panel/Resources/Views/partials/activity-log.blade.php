<!-- activity logs --->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    بخش لاگ
                </h5>
                <p>
                    در این بخش اطلاعاتی در مورد عملیات CRUD به شما داده می شود
                </p>
            </section>
            <section class="body-content">
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>توضیحات</th>
                            <th>نام انجام دهنده</th>
                            <th>اطلاعات کلی</th>
                            <th>تاریخ ثبت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($panelRepo->activityLogs() as $log)
                            <tr>
                                <th>{{ $log->id }}</th>
                                <td>{{ $log->log_name }}</td>
                                <td>{{ $log->description() }}</td>
                                <td>{{ $log->causerName() }}</td>
                                <td>
                                    @if(empty($log->properties()))
                                        <span class="text-danger">ویژگی ندارد</span>
                                    @else
                                        @foreach($log->properties() as $key => $value)
                                            {{ $key . ' => ' . $value }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $log->getFaUpdatedDate() }}</td>
                                <td class="width-22-rem text-left">
                                    <a href="{{ $log->path() }}" class="btn btn-outline-primary btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>هیج عملیاتی صورت نگرفته است.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $panelRepo->activityLogs()->links() }}
                </section>
            </section>
        </section>
    </section>
</section>
