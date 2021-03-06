<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\DB;

class Product extends Model {

    use SoftDeletes;

    /**
     * Fillable fields for a Product.
     *
     * @var array
     */
    protected $fillable = [
        'mandante',
        'cost_id',
        'nome',
        'imagem',
        'promocao',
        'valorUnitVenda',
        'valorUnitVendaPromocao',
        'valorUnitCompra',
    ];

    /**
     * @var String
     */
    private $filtro;

    /**
     * Partner can have many orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itemOrders(){
        return $this->hasMany('ItemOrder');
    }

    /**
     * Get the groups associated with the given product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups() {
        return $this->belongsToMany('ProductGroup')->withTimestamps();
    }

    public function getGroupListAttribute(){
        $groups = $this->groups->toArray();
        $lista = '';
        foreach($groups as $group){
            $lista = $lista . $group['grupo'].', ';
        }
        return substr($lista, 0, -2);
    }

//    public function filtraCachedGroup($filtro, CacheRepository $cache) {
//        $this->filtro=$filtro;
//        $cacheKey = 'getCachedFiltraGrupo234'.str_slug($filtro).md5($this->select(DB::raw('max(updated_at), count(id)'))->first()->toJson());
//        if (!$cache->has($cacheKey)) {
//            $filtered = $this->orderBy('promocao', 'desc' )->orderBy('nome', 'asc' )->get()->filter(function($item) {
//                $found = false;
//                foreach ($item->groups->toArray() as $group) {
//                    if (array_search($this->filtro,$group)) $found = true;
//                }
//                if ($found) return $item;
//            });
//            $cache->put($cacheKey, $filtered, config('cache.queryCacheTimeMinutes'));
//        }
//        return $cache->get($cacheKey);
//    }

//    public function filtraGroup($filtro) {
//        $this->filtro=$filtro;
//        return $this->all()->filter(function($item) {
//            $found = false;
//            foreach ($item->groups->toArray() as $group) {
//                if (array_search($this->filtro,$group)) $found = true;
//            }
//            if ($found) return $item;
//        });
//    }

//    public function getCachedLatestPublished(CacheRepository $cache){
//        $cacheKey = 'getCachedLatestPublished'.md5($this->select(DB::raw('max(updated_at), count(id)'))->first()->toJson());
//        if (!$cache->has($cacheKey)) {
//            $cache->put($cacheKey, $this->latest('published_at')->published()->get(), Carbon::now()->addDay());
//        }
//        return $cache->get($cacheKey);
//    }

    /**
     * Get the status associated with the given Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function status() {
        return $this->belongsToMany('SharedStat')->withTimestamps();
    }

    public function getStatusListAttribute(){
        $status = $this->status->toArray();
        $lista = '';
        foreach($status as $stat){
            $lista = $lista . $stat['descricao'].', ';
        }
        return substr($lista, 0, -2);
    }

}
