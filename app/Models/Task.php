<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_structure_id',
        'user_id',
        'name',
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
        return $this->belongsTo(TaskType::class, 'task_types_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
