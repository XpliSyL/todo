<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
