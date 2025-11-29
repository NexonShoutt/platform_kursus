<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function contents() {
        return $this->hasMany(Content::class);
    }
    public function students() {
        return $this->belongsToMany(User::class, 'course_user');
    }
}
