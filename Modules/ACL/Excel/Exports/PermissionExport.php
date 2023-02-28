<?php

namespace Modules\ACL\Excel\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\ACL\Repositories\RolePermissionRepoEloquent;

class PermissionExport implements FromCollection
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        $repo = new RolePermissionRepoEloquent();
        return $repo->getAllPermissions()->except(['guard']);
    }
}
