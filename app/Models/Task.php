<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_structure_id',
        'user_id',
        'title',
        'details',
        'due_date',
        'status',
        'updated_at',
        'created_at'
    ];

    protected $casts = [
        'status' =>  TaskStatus::class,
    ];

    public function project_structure()
    {
        return $this->belongsTo(ProjectStructure::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->hasOne(TaskType::class);
    }
}
