<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassYear extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_class_id',
        'school_year_id',
    ];

    /**
     * Get the school class that owns the ClassYear
     *
     * @return BelongsTo
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * Get the school year that owns the ClassYear
     *
     * @return BelongsTo
     */
    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * Get all of the enrollment classes for the ClassYear
     *
     * @return HasMany
     */
    public function enrollmentClasses(): HasMany
    {
        return $this->hasMany(EnrollmentClass::class);
    }

    /**
     * Get all of the class courses for the ClassYear
     *
     * @return HasMany
     */
    public function classCourses(): HasMany
    {
        return $this->hasMany(ClassCourse::class);
    }
}
