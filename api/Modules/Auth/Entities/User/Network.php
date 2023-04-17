<?php

namespace Modules\Auth\Entities\User;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Modules\Shared\Entities\User\User;

/**
 * Class Network
 * @package Modules\Auth\Entities\User
 */
final class Network extends Model
{
    use Uuid;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'user_networks';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $hidden = [
        'access_token', 'refresh_token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
