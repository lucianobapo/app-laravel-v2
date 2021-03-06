<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OldOrder extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'erpnet_ordem';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['empresa', 'tipo', 'valor'];

    public function listar() {
        $results = DB::connection('mysql_erpnet')
            ->select('select * from erpnet_ordem where empresa="ilhanet" and status_cancelado=0');
        foreach ($results as $resout) $resout->data_termino=Carbon::parse(date('Y-m-d',$resout->data_termino));
//        dd(Carbon::parse(date('Y-m-d',$resout->data_termino)));
//        return Carbon::parse($results->data_termino)->format('Y-m-d');
        return $results;
    }

    public function listarItens($ordem) {
        $results = DB::connection('mysql_erpnet')
            ->select('select * from erpnet_ordem_item where id_ordem='.$ordem);
        return $results;
    }
    public function listarWbs($id) {
        $results = DB::connection('mysql_erpnet')
            ->select('select * from erpnet_wbs where id='.$id);
        return $results;
    }


    public function listarOrdens($tipo='%', $conditions ='') {
        //$conditions ='';
        $results = DB::connection('mysql_erpnet')
            ->select('select * from erpnet_ordem where empresa=:empresa
                and tipo LIKE :tipo '.$conditions.' and status_cancelado=0 and status_fechado=1
                ORDER BY data_termino',[
                'empresa'=>"ilhanet",
                'tipo'=>$tipo,
            ]);
        //foreach ($results as $resout) $resout->data_termino=Carbon::parse(date('Y-m-d',$resout->data_termino));
        return $results;
    }

    public function listarOrdensResumidas($tipo='%', $conditions ='') {
        $results = DB::connection('mysql_erpnet')
            ->select("SELECT FROM_UNIXTIME(CONVERT(data_termino,UNSIGNED INTEGER),'%Y-%m-01') data, sum(valor) valor
                from erpnet_ordem where empresa=:empresa
                and tipo LIKE :tipo ".$conditions." and status_cancelado=0 and status_fechado=1
                GROUP BY data
                ORDER BY data",[
                'empresa'=>"ilhanet",
                'tipo'=>$tipo,
            ]);
        //foreach ($results as $resout) $resout->data_termino=Carbon::parse(date('Y-m-d',$resout->data_termino));
        //dd($results);
        return $results;
    }

    public function getWbs($id) {
        //$conditions ='';
        $results = DB::connection('mysql_erpnet')
            ->select('select * from erpnet_wbs where id=:id',[
                'id'=>$id,
            ]);
        //foreach ($results as $resout) $resout->data_termino=Carbon::parse(date('Y-m-d',$resout->data_termino));
        return $results;
    }

    public function isWbs($id){
        return (count($this->getWbs($id))>0);
    }
}
