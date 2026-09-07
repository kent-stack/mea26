<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'report_type',
        'title',
        'description',
        'photos',
        'submitted_by',
        'student_name',
        'student_email',
        'rating',
        'admin_id',
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
