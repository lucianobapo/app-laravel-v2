<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\OldOrder;
use Illuminate\Http\Request;

class RelatoriosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $primeira_data = time();
        $primeira_data_diario = time();

        $scopes=['total'];
        if ((new OldOrder)->isWbs(411)) array_push($scopes,'411');
        if ((new OldOrder)->isWbs(412)) array_push($scopes,'412');
        if ((new OldOrder)->isWbs(416)) array_push($scopes,'416');

        foreach ($scopes as $scope) {
            $receitas[$scope.'_acumulado'] = $this->getFloatDataAcumulado('venda', $primeira_data, $scope=='total'?'':'and id_wbs='.$scope );
            $despesas[$scope.'_acumulado'] = $this->getFloatDataAcumulado('compra', $primeira_data, $scope=='total'?'':'and id_wbs='.$scope );
            $receitas[$scope.'_comparado'] = $this->getFloatDataBarras('venda', $primeira_data, $scope=='total'?'':'and id_wbs='.$scope );
            $despesas[$scope.'_comparado'] = $this->getFloatDataBarras('compra', $primeira_data, $scope=='total'?'':'and id_wbs='.$scope );
            $lucro[$scope] = $this->getFloatDataLucro($primeira_data, $scope=='total'?'':'and id_wbs='.$scope );
            $lucroDiario[$scope] = $this->getFloatDataLucroDiario($primeira_data_diario, ($scope=='total'?'':'and id_wbs='.$scope).' and data_termino >= '.strtotime('-1 month'), $media, $mediaValor);
            $lucroDiario[$scope.'_media'] = $media;
            $lucroDiario[$scope.'_mediaValor'] = $mediaValor;
        }

        return view('relatorios.listar', compact(
            'receitas',
            'despesas',
            'lucro',
            'lucroDiario',
            'scopes',
            'escala',
            'primeira_data',
            'primeira_data_diario'
        ));
	}

    /**
     * @param $tipo
     * @param $primeira_data
     * @return string
     */
    private function getFloatDataAcumulado($tipo, &$primeira_data, $conditions ='')
    {
        $ordens = (new OldOrder)->listarOrdens($tipo, $conditions);
        $soma = 0;
        $datas = array();
        $saida = '';
        foreach ($ordens as $ordem) {
            if ($ordem->data_termino < $primeira_data) $primeira_data = $ordem->data_termino;
            $soma = $soma + (is_object($ordem) ? $ordem->valor : 0);
            $datas[$ordem->data_termino] = $soma;
            //$saida=$saida."[".($ordem->data_termino*1000).", $soma],";
        }
        foreach ($datas as $key => $valor) {
            $saida = $saida . "[" . ($key * 1000) . ", $valor],";
        }
        return substr($saida, 0, -1);
    }


    /**
     * @param $tipo
     * @param $primeira_data
     * @return string
     */
    private function getFloatDataBarras($tipo, &$primeira_data, $conditions ='')
    {
        $ordens = (new OldOrder)->listarOrdensResumidas($tipo, $conditions);
        $saida = '';
        foreach ($ordens as $ordem) {
//            if ($ordem->data_termino < $primeira_data) $primeira_data = $ordem->data_termino;
//            $saida=$saida."[".($ordem->data_termino*1000).", ".$ordem->valor."],";
            if (strtotime($ordem->data)<$primeira_data) $primeira_data=strtotime($ordem->data);
            $saida=$saida."[".(strtotime($ordem->data)*1000).", ".$ordem->valor."],";
        }
        return substr($saida, 0, -1);
    }

    /**
     * @param $primeira_data
     * @param string $conditions
     * @return string
     * @internal param $tipo
     */
    private function getFloatDataLucro(&$primeira_data, $conditions ='')
    {
        //$vendas = (new \App\OldOrder)->listarOrdensResumidas('vendas');
        //$compras = (new \App\OldOrder)->listarOrdensResumidas('compras');

        $ordens = (new OldOrder)->listarOrdens('%', $conditions);
        //$soma = 0;
        $datas = array();
        $saida = '';
        foreach ($ordens as $ordem) {
            if ($ordem->data_termino < $primeira_data) $primeira_data = $ordem->data_termino;
            //$soma = $soma + (is_object($ordem) ? $ordem->valor : 0);
            $mes=mktime(null,null,null,date('m',$ordem->data_termino),1,date('Y',$ordem->data_termino));
            isset($datas[$mes])?:$datas[$mes]=0;
            $datas[$mes] = ($ordem->tipo=='venda' ? $datas[$mes]+$ordem->valor : ($ordem->tipo=='compra' ? $datas[$mes]-$ordem->valor : $datas[$mes]));
            //$saida=$saida."[".($ordem->data_termino*1000).", $soma],";
        }
        //dd($datas);
        foreach ($datas as $key => $valor) {
            $saida = $saida . "[" . ($key * 1000) . ", $valor],";
        }
        return substr($saida, 0, -1);
    }

    /**
     * @param $primeira_data
     * @param string $conditions
     * @return string
     * @internal param $tipo
     */
    private function getFloatDataLucroDiario(&$primeira_data, $conditions ='', &$saidaMedia, &$mediaValor)
    {
        $ordens = (new OldOrder)->listarOrdens('%', $conditions);
        $datas = array();
        $soma = 0;
        foreach ($ordens as $ordem) {
            if ($ordem->data_termino < $primeira_data) $primeira_data = $ordem->data_termino;
            isset($datas[$ordem->data_termino])?:$datas[$ordem->data_termino]=0;
            $datas[$ordem->data_termino] = $ordem->tipo == 'venda' ? $datas[$ordem->data_termino] + $ordem->valor : ($ordem->tipo == 'compra' ? $datas[$ordem->data_termino] - $ordem->valor : $datas[$ordem->data_termino]);
            $soma = $soma + $datas[$ordem->data_termino];
        }

        $mediaValor = $soma / count($datas);
        $saidaMedia = '';
        $saida = '';
        foreach ($datas as $key => $valor) {
            $saida = $saida . "[" . ($key * 1000) . ", $valor],";
            $saidaMedia = $saidaMedia . "[" . ($key * 1000) . ", $mediaValor],";
        }
        //dd($i);
        $saidaMedia = substr($saidaMedia, 0, -1);
        //dd($max);
        return substr($saida, 0, -1);
    }
}
