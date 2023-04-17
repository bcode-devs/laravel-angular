<?php

namespace Modules\Shared\Entities\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Modules\Auth\Entities\User\AuthUserTrait;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Entities\User\Network;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property int $id
 * @property int $ident
 * @property int $url
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property string $verify_token
 * @property string $role
 * @property string $avatar
 * @property string $email_verified_at
 * @property string $avatar_url
 * @property string $status
 * @property bool $verified
 * @property Network[] networks
 *
 * @method Builder byNetwork(string $network, string $identity)
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use Uuid;

    // Use Auth module
    use AuthUserTrait;

    protected $keyType = 'string';

    public $incrementing = false;

    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_BANNED = 'banned';
    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'phone', 'password', 'verify_token', 'status',
        'role', 'avatarUrl', 'banned_reason', 'last_seen', 'avatar_thumbnail_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token', 'avatar', 'avatar_thumbnail',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function (User $model) {
            $model->ident = Str::random(6);
            $url = substr($model->name, 0, 80);
            $model->url = Str::slug($url).'-'.Str::random(6);
            $model->save();
        });
    }
}
