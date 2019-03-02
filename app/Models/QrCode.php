<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
