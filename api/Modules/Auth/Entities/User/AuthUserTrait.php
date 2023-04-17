<?php

namespace Modules\Auth\Entities\User;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Shared\Entities\User\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use DomainException;

/**
 * @property string ident
 * @property string url
 * @property string phone
 * @property string last_seen
 */
trait AuthUserTrait
{
    use HasApiTokens;

    public static function register(string $name, string $email, string $password = null): self
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'status' => self::STATUS_WAIT,
            'role' => self::ROLE_USER,
            'verify_token' => Str::uuid(),
            'password' => bcrypt($password),
        ]);
    }

    public static function networkRegister(string $name, string $email): self
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'status' => self::STATUS_ACTIVE,
            'role' => self::ROLE_USER,
            'password' => null,
        ]);
    }

    public static function new($name, $email, $password, $status, $role): self
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
            'status' => $status,
        ]);
    }

    public static function rolesList(): array
    {
        return [
            self::ROLE_USER => 'Пользователь',
            self::ROLE_MODERATOR => 'Модератор',
            self::ROLE_ADMIN => 'Админ',
        ];
    }

    public static function statusList(): array
    {
        return [
            User::STATUS_WAIT => 'Не подтвержден',
            User::STATUS_ACTIVE => 'Активен',
            User::STATUS_BANNED => 'Забанен',
        ];
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isBanned(): bool
    {
        return $this->status === self::STATUS_BANNED;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function verify(): void
    {
        if (!$this->isWait()) {
            throw new DomainException('User is already verified.');
        }

        $this->update([
            'status' => self::STATUS_ACTIVE,
            'verify_token' => null,
        ]);
    }

    public function networks(): HasMany
    {
        return $this->hasMany(Network::class, 'user_id', 'id');
    }
}
