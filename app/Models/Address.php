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

    /**
     * Address can have many orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany('Order');
    }

    /**
     * Get the endereco attribute.
     * @return string
     */
    public function getEnderecoAttribute() {

        return $this->attributes['logradouro'].', '.$this->attributes['numero']
            .(empty($this->attributes['complemento'])?'':' - '.$this->attributes['complemento'])
            .(empty($this->attributes['bairro'])?'':' - '.$this->attributes['bairro']);
            //.(empty($this->attributes['cep'])?'':' - CEP: '.$this->attributes['cep'])
            //.(empty($this->attributes['cidade'])?'':' - '.$this->attributes['cidade'])
            //.(empty($this->attributes['estado'])?'':'/'.$this->attributes['estado']);
    }

}
