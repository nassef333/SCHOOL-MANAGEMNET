<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Define the relationship for the supervisor
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_trainings', 'training_id', 'teacher_id')
                    ->withPivot('is_done');
    }
}
