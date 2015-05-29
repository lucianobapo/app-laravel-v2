<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traffic extends Model {

    /**
     * Fillable fields for a Traffic.
     *
     * @var array
     */
    protected $fillable = [
        'user_info',
        'server_info',
    ];

}
