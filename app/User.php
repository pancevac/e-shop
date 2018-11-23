<?php

namespace App;

use App\Traits\HasPermissionTrait;
use App\Traits\UploadableImageTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Actuallymab\LaravelComment\CanComment;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, UploadableImageTrait, HasPermissionTrait, CanComment;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'block', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Add global scopes
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('role', function ($builder) {
            $builder->with('role');
        });
    }

    /**
     * Override method of CanComment trait, check if user is admin, if he is,
     * his comments are automatically approved.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return true;//$this->isSuperAdmin();
    }

    /**
     * Return is user a customer
     *
     * @return bool
     */
    public function isCustomer()
    {
        return $this->role_id == 0 ? true : false;
    }

    /**
     * Set user's hash password.
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the flag label for block field.
     *
     * @param $block
     * @return bool
     */
    public function getBlockAttribute($block)
    {
        return (bool) $block;
    }

    /**
     * Get the flag label for image field.
     *
     * @return mixed
     */
    public function getProfileImageAttribute()
    {
        return \Imagecache::get($this->attributes['image'], 'profile_image')->src;
    }

    /**
     * Define relationship for products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Define relationship for role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
