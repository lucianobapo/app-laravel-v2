<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Partner extends Model {

    use SoftDeletes;

    /**
     * Fillable fields for a Partner.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'user_id',
        'nome',
        'data_nascimento',
    ];

    /**
     * A Partner belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('User');
    }



    /**
     * Partner can have many orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany('Order');
    }

    /**
     * Partner can have many addresses.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses(){
        return $this->hasMany('Address');
    }

    /**
     * Partner can have many contacts.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts(){
        return $this->hasMany('Contact');
    }

}
