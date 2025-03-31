<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CanvasModule extends Model
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
        'canvas_course_id',
    ];

    /**
     * Get the course that owns the CanvasModule
     *
     * @return BelongsTo
     */
    public function canvasCourse(): BelongsTo
    {
        return $this->belongsTo(CanvasCourse::class);
    }

    /**
     * Get all of the class course modules for the CanvasModule
     *
     * @return HasMany
     */
    public function classCourseModules(): HasMany
    {
        return $this->hasMany(ClassCourseModule::class);
    }
}
