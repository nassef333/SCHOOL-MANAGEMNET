<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
// use Filament\Tables\Columns\Layout\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;


class User extends Authenticatable implements FilamentUser
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
        'password' => 'hashed'
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject');
    }

    public function getRoleNameAttribute()
    {
        return $this->role_id == 1 ? 'Supervisor' : 'Teacher';
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


    // All User Ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'teacher_id');
    }

    public function calculateAverageRatings()
    {
        $ratings = $this->ratings;

        // Check if there are any ratings
        if ($ratings->isEmpty()) {
            return [
                'molars_and_skills' => 0,
                'homework' => 0,
                'planning' => 0,
                'media_usage' => 0,
                'learning_strategy' => 0,
                'manage_class' => 0,
                'overall_average' => 0,
            ];
        }

        $averageRatings = [
            'molars_and_skills' => $ratings->avg('molars_and_skills'),
            'homework' => $ratings->avg('homework'),
            'planning' => $ratings->avg('planning'),
            'media_usage' => $ratings->avg('media_usage'),
            'learning_strategy' => $ratings->avg('learning_strategy'),
            'manage_class' => $ratings->avg('manage_class'),
        ];

        // Calculate the overall average
        $averageRatings['overall_average'] = array_sum($averageRatings) / count($averageRatings);

        // Ensure the overall average is out of 5
        $averageRatings['overall_average'] = ($averageRatings['overall_average'] / 5) * 5;

        return $averageRatings;
    }
    
}
