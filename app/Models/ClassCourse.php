<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassCourse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class_year_id',
        'canvas_course_id',
    ];

    /**
     * Get the class year that owns the ClassCourse
     *
     * @return BelongsTo
     */
    public function classYear(): BelongsTo
    {
        return $this->belongsTo(ClassYear::class);
    }

    /**
     * Get the canvas course that owns the ClassCourse
     *
     * @return BelongsTo
     */
    public function canvasCourse(): BelongsTo
    {
        return $this->belongsTo(CanvasCourse::class);
    }

    /**
     * Get all of the class course modules for the ClassCourse
     *
     * @return HasMany
     */
    public function classCourseModules(): HasMany
    {
        return $this->hasMany(ClassCourseModule::class);
    }
}
