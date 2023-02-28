<?php

namespace Modules\ACL\Excel\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\ACL\Entities\Role;

class RoleImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Role
     */
    public function model(array $row): Role
    {
        return new Role([
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
