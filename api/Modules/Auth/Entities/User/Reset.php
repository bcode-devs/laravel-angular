<?php

namespace Modules\Auth\Entities\User;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Reset
 * @package Modules\Auth\Entities\User
 */
final class Reset extends Model
{
    protected $primaryKey = 'email';

    const UPDATED_AT = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'password_reset_tokens';

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}
