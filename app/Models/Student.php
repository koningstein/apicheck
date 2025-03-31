<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'eduarteid',
        'canvasid',
        'isactive',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'isactive' => 'boolean',
    ];

    /**
     * Get all of the enrollments for the Student
     *
     * @return HasMany
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the active enrollment for the student.
     */
    public function activeEnrollment()
    {
        return $this->enrollments()->whereHas('status', function($query) {
            $query->where('name', 'Actief');
        })->latest()->first();
    }
}
