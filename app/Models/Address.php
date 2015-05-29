<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {

    use SoftDeletes;

    /**
     * Fillable fields for an Address.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'partner_id',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'pais',
        'obs',
        //'principal',
        //'cancelado',
    ];

    /**
     * An Address is owned by a partner.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner(){
        return $this->belongsTo('Partner');
    }
}
