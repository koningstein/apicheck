<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'crebo_id',
        'cohort_id',
        'status_id',
        'enrollmentdate',
        'enddate',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enrollmentdate' => 'date',
        'enddate' => 'date',
    ];

    /**
     * Get the student that owns the Enrollment
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the crebo that owns the Enrollment
     *
     * @return BelongsTo
     */
    public function crebo(): BelongsTo
    {
        return $this->belongsTo(Crebo::class);
    }

    /**
     * Get the cohort that owns the Enrollment
     *
     * @return BelongsTo
     */
    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }

    /**
     * Get the status that owns the Enrollment
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }


    /**
     * Get all of the enrollment classes for the Enrollment
     *
     * @return HasMany
     */
    public function enrollmentClasses(): HasMany
    {
        return $this->hasMany(EnrollmentClass::class);
    }
}
