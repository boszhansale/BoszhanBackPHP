<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string $login
 * @property string $password
 * @property string|null $id_1c
 * @property string|null $device_token
 * @property int $winning_access
 * @property int $payout_access
 * @property string|null $remember_token
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $driverOrders
 * @property-read int|null $driver_orders_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $salesrepOrders
 * @property-read int|null $salesrep_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Store[] $stores
 * @property-read int|null $stores_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 *
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId1c($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePayoutAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWinningAccess($value)
 * @mixin \Eloquent
 *
 * @property int|null $status
 * @property int|null $plan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Counteragent[] $counteragents
 * @property-read int|null $counteragents_count
 * @property-read User|null $driver
 * @property-read \App\Models\PlanGroupUser|null $planGroupUser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserRole[] $userRoles
 * @property-read int|null $user_roles_count
 *
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 *
 * @property string|null $lat
 * @property string|null $lng
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BrandPlanUser[] $brandPlans
 * @property-read int|null $brand_plans_count
 * @property-read \App\Models\Counterparty|null $counterparty
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $drivers
 * @property-read int|null $drivers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $salesreps
 * @property-read int|null $salesreps_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLng($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserPosition[] $userPositions
 * @property-read int|null $user_positions_count
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'password',
        'login',
        'id_1c',
        'device_token',
        'winning_access',
        'payout_access',
        'created_at',
        'lat',
        'lng',
        'inventory_number',
        'sim_number',
        'case',
        'screen_security',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [

    ];

    public function isAdmin()
    {
        return $this->role()->where('roles.id', 3)->exists();
    }

    public function isDriver(): bool
    {
        return $this->role()->where('roles.id', 2)->exists();
    }

    public function isSalesrep(): bool
    {
        return $this->role()->where('roles.id', 1)->exists();
    }

    public function isSupervisor(): bool
    {
        return $this->role()->where('roles.id', 8)->exists();
    }

    public function counterparty()
    {
        return $this->hasOne(Counterparty::class);
    }

    public function driverOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function salesrepOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'salesrep_id');
    }

    public function roles(): HasManyThrough
    {
        return $this->hasManyThrough(Role::class, UserRole::class, '', 'id', '', 'role_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'salesrep_id');
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserRole::class);
    }

    public function driver(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, DriverSalesrep::class, 'salesrep_id', 'id', 'id', 'driver_id');
    }

    public function drivers(): HasManyThrough
    {
        return $this->HasManyThrough(User::class, DriverSalesrep::class, 'salesrep_id', 'id', 'id', 'driver_id');
    }

    public function salesreps(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, DriverSalesrep::class, 'driver_id', 'id', 'id', 'salesrep_id');
    }

    public function supervisorsSalesreps(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            SupervisorSalesrep::class,
            'supervisor_id',
            'id',
            'id',
            'salesrep_id'
        );
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, $this->isSalesrep() ? 'salesrep_id' : 'driver_id');
    }

    public function counteragents(): HasManyThrough
    {
        return $this->hasManyThrough(Counteragent::class, CounteragentUser::class, '', 'id', '', 'counteragent_id');
//        return $this->hasManyThrough(Counteragent::class,CounteragentUser::class,'','id','user_id','counteragent_id');
    }

    public function planGroupUser(): BelongsTo
    {
        return $this->belongsTo(PlanGroupUser::class, 'id', 'user_id');
    }

    public function brandPlans(): HasMany
    {
        return $this->hasMany(BrandPlanUser::class);
    }

    public function counteragentExist($counteragentId)
    {
        return CounteragentUser::where('counteragent')->exists();
    }

    public function permissionExists($permission): bool
    {
        return Permission::join('role_permissions', 'role_permissions.permission_id', 'permissions.id')
            ->join('user_roles', 'user_roles.role_id', 'role_permissions.role_id')
            ->where('user_roles.user_id', $this->id)
            ->where('permissions.name', $permission)
            ->exists();
    }

    public function userPositions(): HasMany
    {
        return $this->hasMany(UserPosition::class);
    }

    public function statusDescription()
    {
        switch ($this->status) {
            case 1:
                return 'работает';
            case 2:
                return 'не работает';
        }
    }
}
