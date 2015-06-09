<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemOrder extends Model {

    /**
     * Fillable fields for an Item Order.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'order_id',
        'cost_id',
        'product_id',
        'currency_id',
        'quantidade',
        'valor_unitario',
        'desconto_unitario',
        'descricao',
    ];

    /**
     * An Item Order belongs to an Order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order() {
        return $this->belongsTo('Order');
    }

    /**
     * An Item Order belongs to a Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product() {
        return $this->belongsTo('Product');
    }

    /**
     * An Item Order belongs to an CostAllocate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cost() {
        return $this->belongsTo('CostAllocate');
    }

    /**
     * An Item Order belongs to an SharedCurrency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency() {
        return $this->belongsTo('SharedCurrency');
    }

}
