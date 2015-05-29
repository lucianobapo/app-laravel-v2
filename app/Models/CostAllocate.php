<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostAllocate extends Model {

    /**
     * Fillable fields for a CostAllocate.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'nome',
        'numero',
        'descricao',
    ];

}
