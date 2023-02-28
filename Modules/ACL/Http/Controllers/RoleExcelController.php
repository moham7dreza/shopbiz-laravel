<?php

namespace Modules\ACL\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ACL\Excel\Exports\PermissionExport;
use Modules\ACL\Excel\Exports\RoleExport;
use Modules\ACL\Excel\Imports\PermissionImport;
use Modules\ACL\Excel\Imports\RoleImport;
use Modules\ACL\Http\Requests\ExcelFileRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RoleExcelController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @return Application|Factory|View
     */
    public function excelForm(): View|Factory|Application
    {
        return view('ACL::role.excel-form');
    }

    /**
     * @param ExcelFileRequest $request
     * @return RedirectResponse
     */
    public function roleExcelImport(ExcelFileRequest $request): RedirectResponse
    {
        if ($request->hasFile('file')) {
            Excel::import(new RoleImport(), $request->file('file'));
        }
        return $this->showAlertWithRedirect('نقش ها با موفقیت بارگذاری شد.', route: 'role.index');
    }

    /**
     * @return BinaryFileResponse
     */
    public function roleExcelExport(): BinaryFileResponse
    {
        ShareService::showAnimatedAlert('نقش ها در حال دانلود می باشد.');
        return Excel::download(new RoleExport(), "roles_export.xlsx");
    }
}
