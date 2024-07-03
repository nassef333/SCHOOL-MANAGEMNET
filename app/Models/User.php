<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'mobile', 'email', 'password', 'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject');
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'teacher_trainings');
    }

    public function years()
    {
        return $this->belongsToMany(Year::class, 'teacher_years');
    }

    public function supervisorRatings()
    {
        return $this->hasMany(Rating::class, 'supervisor_id');
    }

    public function teacherRatings()
    {
        return $this->hasMany(Rating::class, 'teacher_id');
    }
}
