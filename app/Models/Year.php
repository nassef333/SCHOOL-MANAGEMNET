<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_years');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
