<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasUuids;
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name'];

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            $activity->id = Str::uuid();
        });
    }
}
