<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'year_id'];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, "branch_teacher", "branch_id", "teacher_id");
    }

    public function users()
    {
        return $this->belongsToMany(User::class, "branch_teacher", "branch_id", "teacher_id");
    }
}
