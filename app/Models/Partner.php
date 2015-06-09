<?php namespace App\Models;

use Carbon\Carbon;
use DebugBar\DebugBar;
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
        'observacao',
    ];

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['data_nascimento'];

    /**
     * Set the data_nascimento attribute.
     *
     * @param $date
     */
    public function setDataNascimentoAttribute($date) {
        $this->attributes['data_nascimento'] = Carbon::parse($date);
    }

    /**
     * Get the data_nascimento attribute.
     *
     * @param $date
     * @return string
     */
    public function getDataNascimentoAttribute($date) {
        if (empty($date))
            return '';
        else
            return Carbon::parse($date)->format('d/m/Y');
    }

    /**
     * Get the groups associated with the given partner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups() {
        return $this->belongsToMany('PartnerGroup')->withTimestamps();
    }

    public function getGroupListAttribute(){
        $groups = $this->groups->toArray();
        $lista = '';
        foreach($groups as $group){
            $lista = $lista . $group['grupo'].', ';
        }
        return substr($lista, 0, -2);
    }



    /**
     * A Partner belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('User');
    }

    /**
     * Get the status associated with the given Partner.
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

    /**
     * Partner can have many documents.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents(){
        return $this->hasMany('Document');
    }

    /**
     * Get the partner_list attribute.
     * @return string
     */
//    public function getPartnerListAttribute() {
////        $partners = SharedStat::where(['status'=>'ativado'])->first()->partners()->get();
////        foreach($partners as $partner) {
//////            $list['id'] = $partner->id;
////            $list['nome'] = $partner->nome;
////        }
////        $endereco = Address::where(['partner_id'=>$this->attributes['id']])->first();
//
////        if (is_null($this->status()->where(['status'=>'ativado'])->first())) {
////            \Debugbar::info($this->attributes['nome']);
////            return $this->attributes['nome'];
////        }else return null;
//        return $this->attributes['nome'];
////        return $list;
//    }
}
