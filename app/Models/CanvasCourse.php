<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CanvasCourse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'canvasid',
        'name',
        'description',
    ];

    /**
     * Get all of the modules for the CanvasCourse
     *
     * @return HasMany
     */
    public function canvasModules(): HasMany
    {
        return $this->hasMany(CanvasModule::class);
    }

    /**
     * Get all of the enrollment class courses for the CanvasCourse
     *
     * @return HasMany
     */
    public function enrollmentClassCourses(): HasMany
    {
        return $this->hasMany(EnrollmentClassCourse::class);
    }
}
