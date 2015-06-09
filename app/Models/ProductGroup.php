<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model {

    /**
     * Fillable fields for a ProductGroup.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'grupo',
    ];

    /**
     * Get the products associated with the given ProductGroup.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products() {
        return $this->belongsToMany('Product')->withTimestamps();
    }

}
