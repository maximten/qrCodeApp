<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class QrCodeType extends Model
{
    /**
     * The user type definition.
     *
     * @var string
     */
    const USER = 'user';

    /**
     * The merchant type definition.
     *
     * @var string
     */
    const MERCHANT = 'merchant';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qr_codes_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['name'];

    /**
     * Name scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    public function scopeName(Builder $query, string $name)
    {
        return $this->where('name', $name);
    }

    /**
     * Get QrCodeType by name
     *
     * @param string $name
     * @return \App\Models\QrCodeType
     */
    public static function getByName(string $name)
    {
        return with(new static)->name($name)->firstOrFail();
    }
}
