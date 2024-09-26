<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'updated_at',
        'created_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'type_id');
    }
}
