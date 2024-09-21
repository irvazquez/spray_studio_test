<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['no_classes', 'price', 'activity_id'];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($package) {
            $package->id = Str::uuid();
        });
    }
}
