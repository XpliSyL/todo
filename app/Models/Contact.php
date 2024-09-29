<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'job_title',
        'phone',
        'email',
        'note',
        'links',
        'entity_id',
    ];

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
