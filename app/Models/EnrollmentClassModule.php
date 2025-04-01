<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrollmentClassModule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enrollment_class_course_id',
        'canvas_module_id',
    ];

    /**
     * Get the enrollment class course that owns the EnrollmentClassModule
     *
     * @return BelongsTo
     */
    public function enrollmentClassCourse(): BelongsTo
    {
        return $this->belongsTo(EnrollmentClassCourse::class);
    }

    /**
     * Get the canvas module that owns the EnrollmentClassModule
     *
     * @return BelongsTo
     */
    public function canvasModule(): BelongsTo
    {
        return $this->belongsTo(CanvasModule::class);
    }
}
