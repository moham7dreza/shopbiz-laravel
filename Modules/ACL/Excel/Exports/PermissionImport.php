<?php

namespace Modules\ACL\Excel\Exports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\ACL\Entities\Permission;

class PermissionImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Permission
     */
    public function model(array $row): Permission
    {
        return new Permission([
            'name' => $row['name'],
            'description' => $row['description'],
            'status' => $row['status'],
        ]);
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
