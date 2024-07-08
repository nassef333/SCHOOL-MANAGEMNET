<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'supervisor_id', 'teacher_id', 'molars_and_skills', 'homework', 'planning',
        'media_usage', 'learning_strategy', 'manage_class', 'branch_id', 'subject_id'
    ];

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }



    public function getSupervisorNameAttribute()
    {
        return $this->supervisor ? $this->supervisor->name : null;
    }

    public function getTeacherNameAttribute()
    {
        return $this->teacher ? $this->teacher->name : null;
    }

    public function getTotalAttribute()
    {
        return $this->molars_and_skills + $this->homework + $this->planning + $this->media_usage + $this->learning_strategy + $this->manage_class;
    }
}
