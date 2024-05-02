<?php

namespace App\Models;

use App\Models\Form;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AllowedDomain extends Model
{
    use HasFactory;
    protected $fillable = [
        'domain',
    ];

    public function form(): HasOne
    {
        return $this->hasOne(Form::class);
    }
}
