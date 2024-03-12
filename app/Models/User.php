<?php

namespace App\Models;

use App\Models\Admin\Tellers\TellerAccount;
use App\Traits\Activeable;
use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens; 
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static Illuminate\Database\Eloquent\Builder active()
 *
 * @property string $name
 * @property mixed $roles
 *
 * */
class User extends Authenticatable
{
    use Activeable;
    // use Authorable;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'active',
        'note',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        // 'role',
        'permissions',
        'role_name',
    ];

    public function getPermissionsAttribute()
    {
        $role = $this->roles;
        if (count($role) > 0) {
            return $role[0]->permissions->pluck('name');
        }

        return [];
    }

    public function getRoleAttribute()
    {
        $role = $this->roles;
        if (count($role) > 0) {
            return collect($role[0])->except('permissions', 'created_at', 'updated_at', 'pivot');
        }

        return [];
    }

    public function getRoleNameAttribute()
    {
        $role = $this->roles;
        if (count($role) > 0) {
            return $role[0]->name;
        }

        return '';
    }

    /*
        scopes
     */

    /**
     * Active function
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
 
    public function scopeOperator(Builder $query): void
    {
        $query->role(['operator', 'admin']);
    }

    public function scopeTellerOrAdmin(Builder $query): void
    {
        $query->role(['operator', 'admin']);
    }

    public function scopeFriends(Builder $query): void
    {
        $query->role('friends and family');
    }

    public function scopeAccounters(Builder $query): void
    {
        $query->role('friends and family');
    }

    /**
     * Admin function
     */
    public function scopeAdmin(Builder $query): void
    {
        $query->role('admin');
    } 
}
