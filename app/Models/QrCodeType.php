<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
