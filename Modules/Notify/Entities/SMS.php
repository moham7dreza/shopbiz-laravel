<?php

namespace Modules\Notify\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaPropertiesTrait;

class SMS extends Model
{

    /**
     * @var string
     */
    protected $table = 'public_sms';

    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;


    /**
     * @var string[]
     */
    protected $fillable = ['title', 'body', 'status', 'published_at'];

    // ********************************************* Relations

    // ********************************************* Methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedTitle(int $size = 50): string
    {
        return Str::limit($this->title, $size);
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedBody(int $size = 50): string
    {
        return Str::limit($this->body, $size);
    }

    /**
     * @return bool
     */
    public function sentStatus(): bool
    {
        return $this->published_at < Carbon::now() && $this->status == $this->statusActive();
    }

    // ********************************************* paths


    // ********************************************* FA Properties
}
