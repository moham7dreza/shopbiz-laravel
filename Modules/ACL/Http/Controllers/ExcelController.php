<?php

namespace Modules\ACL\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ACL\Excel\Exports\PermissionExport;
use Modules\ACL\Excel\Exports\PermissionImport;
use Modules\ACL\Http\Requests\ExcelFileRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @return Application|Factory|View
     */
    public function excelForm(): View|Factory|Application
    {
        return view('ACL::permission.excel-form');
    }

    /**
     * @param ExcelFileRequest $request
     * @return RedirectResponse
     */
    public function permissionExcelImport(ExcelFileRequest $request): RedirectResponse
    {
        if ($request->hasFile('file')) {
            Excel::import(new PermissionImport(), $request->file('file'));
        }
        return $this->showAlertWithRedirect('سطوح دسترسی با موفقیت بارگذاری شد.', route: 'permission.index');
    }

    /**
     * @return BinaryFileResponse
     */
    public function permissionExcelExport(): BinaryFileResponse
    {
        ShareService::showAnimatedAlert('سطوح دسترسی در حال دانلود می باشد.');
        return Excel::download(new PermissionExport(), "permissions_export.xlsx");
    }
}
