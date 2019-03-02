<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class QrCode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['hash', 'url', 'status'];

    /**
     * Get the type.
     */
    public function type()
    {
        return $this->belongsTo(QrCodeType::class);
    }

    /**
     * Generate hash for model
     *
     * @return void
     */
    public function generateHash()
    {
        $this->hash = md5($this->type . $this->url);
        return $this;
    }

    /**
     * Hash scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $hash
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    public function scopeHash(Builder $query, string $hash)
    {
        return $this->where('hash', $hash);
    }

    /**
     * Get QrCode by hash
     *
     * @param string $name
     * @return \App\Models\QrCode
     */
    public static function getByHash(string $hash)
    {
        return with(new static)->hash($hash)->firstOrFail();
    }
}
