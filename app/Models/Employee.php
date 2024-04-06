<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'manager_id', 'department_id', 'salary', 'image'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manager() : BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function tasks() : HasMany
    {
        return $this->hasMany(Task::class);
    }

}
