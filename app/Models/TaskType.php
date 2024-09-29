<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'updated_at',
        'created_at'
    ];

    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
