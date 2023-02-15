<?php

namespace Modules\User\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Address\Entities\Address;
use Modules\Cart\Entities\CartItem;
use Modules\Comment\Entities\Comment;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Post\Entities\Post;
use Modules\Product\Entities\Product;
use Modules\Share\Traits\HasCountersTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketAdmin;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelLike\Traits\Likeable;
use Overtrue\LaravelLike\Traits\Liker;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable,
        HasFaDate, HasRoles, HasPermissions, Liker, Favoriter, HasDefaultStatus;

    public const TYPE_USER = 0;
    public const TYPE_ADMIN = 1;

    public const ACTIVATE = 1;
    public const NOT_ACTIVE = 0;

    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'first_name' . 'last_name'
            ]
        ];
    }

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

    // *********************************************** scope

    /**
     * @param $query
     * @param int $activation
     * @return mixed
     */
    public function scopeActivate($query, int $activation = self::ACTIVATE): mixed
    {
        return $query->where('activation', $activation);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAdmin($query): mixed
    {
        return $query->where('user_type', self::TYPE_ADMIN);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUser($query): mixed
    {
        return $query->where('user_type', self::TYPE_USER);
    }


    // ********************************************* Relations

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

    /**
     * @return HasMany
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class)->whereNull('deleted_at');
    }

    // ********************************************* Methods

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }


    // ********************************************* paths

    public function path(): string
    {
        return route('posts.author', $this->email);
    }

    public function profile(): string
    {
        return asset($this->profile_photo_path);
    }

    // ********************************************* css

    public function cssStatusEmailVerifiedAt(): string
    {
        return $this->email_verified_at ? 'success' : 'danger';
    }

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

    // ********************************************* FA Properties

    /**
     * @return string
     */
    public function getFaMobileNumber(): string
    {
        return '۰' . convertEnglishToPersian($this->mobile);
    }

    /**
     * @return array|string
     */
    public function getFaPostalCode(): array|string
    {
        return convertEnglishToPersian($this->postal_code);
    }

    /**
     * @return array|string
     */
    public function getFaNationalCode(): array|string
    {
        return convertEnglishToPersian($this->national_code);
    }

    /**
     * @return array|int|string
     */
    public function getFaId(): array|int|string
    {
        return convertEnglishToPersian($this->id) ?? $this->id;
    }

    public function textStatusEmailVerifiedAt(): string
    {
        return $this->email_verified_at ? 'تایید شده' : 'تایید نشده';
    }

    public function textActivationStatus(): string
    {
        return $this->activation === 1 ? 'فعال' : 'غیر فعال';
    }

    // ********************************************* FA counters

    /**
     * @return array|int|string
     */
    public function getFaCommentsCount(): array|int|string
    {
        return convertEnglishToPersian($this->comments->count()) ?? 0;
    }

    public function getFaRolesCount(): int|array|string
    {
        return convertEnglishToPersian($this->roles->count()) ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function getFaPermissionsCount(): array|int|string
    {
        return convertEnglishToPersian($this->permissions->count()) ?? 0;
    }

    /**
     * @return array|string
     */
    public function getFaLikesCount(): array|string
    {
        $counter = 0;
//        $posts = Post::query()->where('author_id', $this->id)->withCount('likers')->get();
        foreach ($this->posts as $post) {
            $counter += $post->likers()->count();
        }
        return convertEnglishToPersian($counter);
    }

    /**
     * @return string
     */
    public function getFaPostsCount(): string
    {
        return convertEnglishToPersian($this->posts->count()) ?? 0;
    }

    public function getFaLikedPostsCount(): array|string
    {
        return convertEnglishToPersian($this->likes()->withType(Post::class)->count());
    }

    /**
     * @return array|string
     */
    public function getFaFavoritedPostsCount(): array|string
    {
        return convertEnglishToPersian($this->favorites()->withType(Post::class)->count());
    }

    /**
     * @return array|string
     */
    public function getFaFollowersCount(): array|string
    {
        return convertEnglishToPersian($this->followers()->count());
    }

    /**
     * @return array|string
     */
    public function getFaFollowingsCount(): array|string
    {
        return convertEnglishToPersian($this->followings()->count());
    }
}
