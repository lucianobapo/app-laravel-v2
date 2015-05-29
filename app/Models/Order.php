<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {

    use SoftDeletes;

    /**
     * Fillable fields for an Order.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'partner_id',
        'currency_id',
        'shared_order_type_id',
        'shared_order_payment_id',
        'valor_total',
        'desconto_total',
        'troco',
        'descricao',
        'referencia',
        'obsevacao'
    ];

    /**
     * An Order belongs to a Partner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner() {
        return $this->belongsTo('Partner');
    }

    /**
     * An Order belongs to a Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency() {
        return $this->belongsTo('SharedCurrency');
    }

    /**
     * An Order belongs to an Order Type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderType() {
        return $this->belongsTo('SharedOrderType');
    }

    /**
     * An Order belongs to an Order Payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderPayment() {
        return $this->belongsTo('SharedOrderPayment');
    }


    /**
     * Get the status associated with the given order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function status() {
        return $this->belongsToMany('SharedStat')->withTimestamps();
    }

    /**
     * Order can have many items.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(){
        return $this->hasMany('ItemOrder');
    }

}
