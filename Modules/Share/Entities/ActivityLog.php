<?php

namespace Modules\Share\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;

class ActivityLog extends Model
{
    use HasFactory, HasFaDate;

    protected $table = 'activity_log';

    // methods

    /**
     * @return string
     */
    public function description(): string
    {
        return Str::limit($this->description);
    }

    /**
     * @return string
     */
    public function causerName(): string
    {
        return $this->causer_type::query()->findOrFail($this->causer_id)->fullName ?? 'ایجاد کننده ندارد.';
    }

    /**
     * @return mixed
     */
    public function properties()
    {
        return json_decode($this->properties, true);
    }

    /**
     * @return string
     */
    public function path(): string
    {
        $modelObject = $this->subject_type::findOrFail($this->subject_id);
        if ($this->log_name === 'products') {
            if (is_null($modelObject)) { return '#'; }
            return route('customer.market.product', $modelObject);
        }
        else if ($this->log_name === 'users') {
            if (is_null($modelObject)) { return '#'; }
            return $modelObject->user_type == 1 ? route('adminUser.edit', $modelObject)
                : route('customerUser.edit', $modelObject);
        }
        else{
            return '#';
        }
    }
}
