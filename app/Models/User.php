<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function loans()
    {
        return $this->hasMany(Loan::class, 'created_by');
    }
    
    public function adminlte_image()
    {
        if ($this->hasRole('admin')) 
        {
            $userGalleryImage = $this->getFirstMediaUrl('userGallery');
            return $userGalleryImage ?: url('img/userDefault.png');
        }

        if ($this->hasRole('supervisor'))
        {
            $departmentImage = $this->getFirstMediaUrl('departmentGallery');
            return $departmentImage ?: url('img/logo.png');
        }
    }

    public function adminlte_desc()
    {
        $role = $this->getRoleNames()->first();
        return $role ?? 'Unknown Role';
    }

    public function adminlte_profile_url()
    {
        return route('profiles.index');
    }
}
