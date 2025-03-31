<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
