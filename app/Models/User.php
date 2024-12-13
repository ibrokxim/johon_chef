<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, boolean>
     */
    protected $fillable = [
        'chat_id',
        'referrer_id',
        'referral_token',
        'count_referrer',
        'name',
        'email',
        'phone',
        'step',
        'lang',
        'in_auth',
        'confirm_offer',
        'password',
        'role_id',
        'banned',
        'status'
    ];

    protected $with = [
        'role',
        'referrals'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, foreignKey: 'id', localKey: 'role_id');
    }

    public function generateReferralToken(): void
    {
        $this->referral_token = Str::random(10); // Генерация случайного токена
        $this->save();
    }

    /**
     * Генерация реферальной ссылки для Telegram бота.
     */
    public function getTelegramReferralLink(): string
    {
        if (!$this->referral_token) {
            $this->generateReferralToken();
        }

        // Возвращаем реферальную ссылку на бота с токеном
        $botUsername = env('TELEGRAM_BOT_USERNAME');
        return "{$botUsername}?start=" . $this->referral_token;
    }

    /**
     * Получить реферера пользователя
     *
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Получить рефералов (приглашенных пользователей)
     *
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referrer_id')->orderBy('id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->where('is_active', true);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription() !== null;
    }

    /**
     * Проверка аутентификации
     *
     * @param Builder $query
     * @return void
     */
    public function scopeAuth(Builder $query): void
    {
        $query->where('in_auth', 1);
    }

    /**
     * Проверка статуса
     *
     * @param Builder $query
     * @return void
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}
