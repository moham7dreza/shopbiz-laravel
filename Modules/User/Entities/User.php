<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Modules\Comment\Entities\Comment;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Post\Entities\Post;
use Modules\Product\Entities\Product;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasPermission;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketAdmin;

class User extends Authenticatable
{
    use HasApiTokens
        , HasFactory
        , HasProfilePhoto
        , Notifiable
        , TwoFactorAuthenticatable, HasPermission, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

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
    public function ticketAdmin(): HasOne
    {
        return $this->hasOne(TicketAdmin::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }

    public function hasPosts(): HasMany
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
}
