<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'assigned_to',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Relationships

    /**
     * User the task is assigned to.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * User who created the task.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
