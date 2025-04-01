<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnrollmentClass extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enrollment_id',
        'class_year_id',
    ];

    /**
     * Get the enrollment that owns the EnrollmentClass
     *
     * @return BelongsTo
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the class year that owns the EnrollmentClass
     *
     * @return BelongsTo
     */
    public function classYear(): BelongsTo
    {
        return $this->belongsTo(ClassYear::class);
    }

    /**
     * Get all of the enrollment class courses for the EnrollmentClass
     *
     * @return HasMany
     */
    public function enrollmentClassCourses(): HasMany
    {
        return $this->hasMany(EnrollmentClassCourse::class);
    }

    /**
     * Get the student through the enrollment relationship
     */
    public function student()
    {
        return $this->enrollment->student;
    }
}
