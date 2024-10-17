<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends Model
{
    use SoftDeletes;

    public $table = 'tasks';

    public $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'status' => 'string',
        'due_date' => 'datetime'
    ];


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
