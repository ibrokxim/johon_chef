<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
    ];

    public const USER        = 1;
    public const ADMIN       = 2;

    public const ROLES       = [
        self::USER        => 'user',
        self::ADMIN       => 'admin',
    ];

    public const ALIASES  = [
        self::USER        => 'Пользователь',
        self::ADMIN       => 'Администратор',
    ];

    public function isUser(): bool
    {
        return $this->id === self::USER;
    }

    public function isAdmin(): bool
    {
        return $this->id === self::ADMIN;
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
