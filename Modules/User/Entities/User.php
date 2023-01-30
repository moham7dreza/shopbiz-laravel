<?php

namespace Modules\User\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Address\Entities\Address;
use Modules\Comment\Entities\Comment;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Post\Entities\Post;
use Modules\Product\Entities\Product;
use Modules\Share\Traits\HasFaDate;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketAdmin;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelLike\Traits\Likeable;
use Overtrue\LaravelLike\Traits\Liker;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasFaDate, HasRoles, HasPermissions, Liker, Favoriter;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const TYPE_USER = 0;
    public const TYPE_ADMIN = 1;

    public const ACTIVATE = 1;
    public const NOT_ACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'status',
        'user_type',
        'activation',
        'profile_photo_path',
        'password',
        'email_verified_at',
        'mobile_verified_at',
        'national_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Relations

    /**
     * @return HasOne
     */
    public function ticketAdmin(): HasOne
    {
        return $this->hasOne(TicketAdmin::class);
    }

    /**
     * @return HasMany
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->HasMany(Post::class, 'author_id');
    }


    // Methods
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function path(): string
    {
        return route('posts.author', $this->email);
    }

    public function image(): string
    {
        return asset($this->profile_photo_path);
    }

    public function textStatusEmailVerifiedAt(): string
    {
        if ($this->email_verified_at) return 'تایید شده';

        return 'تایید نشده';
    }

    public function cssStatusEmailVerifiedAt(): string
    {
        if ($this->email_verified_at) return 'success';

        return 'danger';
    }

    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    public function textActivationStatus(): string
    {
        return $this->activation === 1 ? 'فعال' : 'غیر فعال';
    }

    // Counters
    public function commentsCount(): int
    {
        return $this->comments->count() ?? 0;
    }

    public function rolesCount(): int
    {
        return $this->roles->count() ?? 0;
    }

    public function permissionsCount(): int
    {
        return $this->permissions->count() ?? 0;
    }

    public function likesCount(): int
    {
        $counter = 0;
//        $posts = Post::query()->where('author_id', $this->id)->withCount('likers')->get();
        foreach ($this->hasPosts as $post) {
            $counter += $post->likers()->count();
        }
        return $counter;
    }

    public function getPostsCount(): string
    {
        return convertEnglishToPersian($this->hasPosts->count()) ?? 0;
    }

    public function likedPostsCount(): int
    {
        return $this->likes()->withType(Post::class)->count();
    }

    public function favoritedPostsCount(): int
    {
        return $this->favorites()->withType(Post::class)->count();
    }

    public function followersCount(): int
    {
        return $this->followers()->count();
    }

    public function followingsCount(): int
    {
        return $this->followings()->count();
    }

    // public function before(User $user, $ability)
    // {
    //     // if($user->is_super_admin === true)
    //     // {
    //     //     return true;
    //     // }

    //     if($user->blocked === true)
    //     {
    //         return false;
    //     }
    // }

    /**
     * @return string
     */
    public function ticketCssStatus(): string
    {
        return is_null($this->ticketAdmin) ? 'success' : 'danger';
    }

    /**
     * @return string
     */
    public function ticketIconStatus(): string
    {
        return is_null($this->ticketAdmin) ? 'check' : 'times';
    }

    /**
     * @return string
     */
    public function faMobileNumber(): string
    {
        return '۰' . convertEnglishToPersian($this->mobile);
    }

    /**
     * @return array|int|string
     */
    public function faId(): array|int|string
    {
        return convertEnglishToPersian($this->id) ?? $this->id;
    }
}
