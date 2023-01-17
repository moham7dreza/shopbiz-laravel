<?php

namespace Modules\Share\Traits;

use Illuminate\Http\RedirectResponse;

trait SuccessToastMessageWithRedirectTrait
{
    /**
     * Show success message with redirect;
     *
     * @param string $title
     * @param array $params
     * @param string $status
     * @return RedirectResponse
     */
    private function successMessageWithRedirect(string $title, string $status = 'swal-success', array $params = []): RedirectResponse
    {
        if (empty($this->redirectRoute)) {
            return redirect()->back()->with('swal-error', 'مسیر برگشت یافت نشد.');
        }

        return to_route($this->redirectRoute, $params)->with($status, $title);
    }

    private function onlyRedirect(array $params = array())
    {
        return to_route($this->redirectRoute, $params);
    }
}
