<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassCourseModule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class_course_id',
        'canvas_module_id',
    ];

    /**
     * Get the class course that owns the ClassCourseModule
     *
     * @return BelongsTo
     */
    public function classCourse(): BelongsTo
    {
        return $this->belongsTo(ClassCourse::class);
    }

    /**
     * Get the canvas module that owns the ClassCourseModule
     *
     * @return BelongsTo
     */
    public function canvasModule(): BelongsTo
    {
        return $this->belongsTo(CanvasModule::class);
    }
}
