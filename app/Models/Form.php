<?php

namespace App\Models;

use App\Models\AllowedDomain;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'limit_one_response',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function allowedDomain(): HasOne
    {
        return $this->hasOne(AllowedDomain::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
    
}
