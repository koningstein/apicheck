<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnrollmentClassCourse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enrollment_class_id',
        'canvas_course_id',
    ];

    /**
     * Get the enrollment class that owns the EnrollmentClassCourse
     *
     * @return BelongsTo
     */
    public function enrollmentClass(): BelongsTo
    {
        return $this->belongsTo(EnrollmentClass::class);
    }

    /**
     * Get the canvas course that owns the EnrollmentClassCourse
     *
     * @return BelongsTo
     */
    public function canvasCourse(): BelongsTo
    {
        return $this->belongsTo(CanvasCourse::class);
    }

    /**
     * Get all of the modules for this enrollment class course
     *
     * @return HasMany
     */
    public function enrollmentClassModules(): HasMany
    {
        return $this->hasMany(EnrollmentClassModule::class);
    }
}
