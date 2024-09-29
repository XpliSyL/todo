<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStructure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'parent_id', 'order'];

    /**
     * Relation : Un niveau peut avoir plusieurs sous-niveaux (enfants).
     */
    public function children()
    {
        return $this->hasMany(ProjectStructure::class, 'parent_id');
    }

    /**
     * Relation : Un niveau peut appartenir à un niveau parent.
     */
    public function parent()
    {
        return $this->belongsTo(ProjectStructure::class, 'parent_id');
    }

    /**
     * Récupérer tous les descendants de façon récursive.
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }
}
