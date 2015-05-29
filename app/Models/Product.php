<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    /**
     * Fillable fields for a Product.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'nome',
        'imagem',
        'promocao',
        'valorUnitVenda',
        'valorUnitVendaPromocao',
        'valorUnitCompra',
    ];

    /**
     * Partner can have many orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemOrders(){
        return $this->hasMany('ItemOrder');
    }

}
