<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['court_id', 'image_path', 'is_primary'])]
class CourtImage extends Model
{
    use HasFactory;

    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }
}
