<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DB;
use Mockery\Exception;
use Psr\Http\Message\RequestInterface;
use Alert;
use URL;

class ItemReqMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMaterial($nr_rm, $ano_rm, $cd_centro)
    {

        $moeda = DB::select('EXEC Proc_MoedaFrequente');

        return view('item_req_material.formMaterial', compact('nr_rm', 'ano_rm', 'cd_centro', 'moeda'));
    }

    public function createServico($nr_rm, $ano_rm, $cd_centro)
    {
        $moeda = DB::select('EXEC Proc_MoedaFrequente');

        return view('item_req_material.formServico', compact('nr_rm', 'ano_rm', 'cd_centro', 'moeda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeMaterial(Request $request)
    {

        $aux = DB::table('Item_Rm')
            ->select('nr_item')
            ->where('nr_rm', $request->nr_rm)
            ->where('ano_rm', $request->ano_rm)
            ->where('cd_centro', $request->cd_centro)
            ->orderBy('nr_item', 'desc')
            ->first();

        if (count($aux)) {
            $nr_item = $aux->nr_item + 1;

        } else {
            $nr_item = 1;
        }

        try {

            if ($request->vl_unit == "") {
                $request->id_moeda = null;
                $request->vl_unit = null;
            }

            $qt_item = str_replace(",", ".", $request->qt_item);

            DB::table('Item_Rm')->insert([

                'NR_RM' => $request->nr_rm,
                'ANO_RM' => $request->ano_rm,
                'CD_CENTRO' => $request->cd_centro,
                'NR_ITEM' => $nr_item,
                'CD_BEMCAT' => null,
                'CD_ALMOX' => $request->itemName[0],
                'CD_MATCAT' => $request->itemName[1] . $request->itemName[2],
                'CD_INDMAT' => $request->itemName[3] . $request->itemName[4] . $request->itemName[5] . $request->itemName[6] . $request->itemName[7],
                'DS_SERV' => null,
                'COMPL_ITEMRM' => $request->compl_itemrm,
                'QT_ITEM' => $qt_item,
                'VL_UNIT' => $request->vl_unit,
                'QT_EMP' => null,
                'NR_EMP' => null,
                'NR_GT' => null,
                'ID_MOEDA' => $request->id_moeda

            ]);

            $nr_rm = $request->nr_rm;
            $ano_rm = $request->ano_rm;
            $cd_centro = $request->cd_centro;

            alert()->success('Item incluído com Sucesso.', '');

            return redirect('item_req_material/' . $nr_rm . '/' . $ano_rm . '/' . $cd_centro . '/showItens');

        } catch (Exception $e) {
            return redirect('req_material')->with('error', 'Algo de errado aconteceu, por favor entre em contato com o NTI.');
        }
    }

    public function storeServico(Request $request)
    {
        $aux = DB::table('Item_Rm')
            ->select('nr_item')
            ->where('nr_rm', $request->nr_rm)
            ->where('ano_rm', $request->ano_rm)
            ->where('cd_centro', $request->cd_centro)
            ->orderBy('nr_item', 'desc')
            ->first();

        if (count($aux)) {
            $nr_item = $aux->nr_item + 1;

        } else {
            $nr_item = 1;
        }

        try {

            if ($request->vl_unit == "") {
                $request->id_moeda = null;
                $request->vl_unit = null;
            }

            $qt_item = str_replace(",", ".", $request->qt_item);

            DB::table('Item_Rm')->insert([

                'NR_RM' => $request->nr_rm,
                'ANO_RM' => $request->ano_rm,
                'CD_CENTRO' => $request->cd_centro,
                'NR_ITEM' => $nr_item,
                'CD_BEMCAT' => null,
                'CD_ALMOX' => null,
                'CD_MATCAT' => null,
                'CD_INDMAT' => null,
                'DS_SERV' => $request->ds_serv,
                'COMPL_ITEMRM' => $request->compl_itemrm,
                'QT_ITEM' => $qt_item,
                'VL_UNIT' => $request->vl_unit,
                'QT_EMP' => null,
                'NR_EMP' => null,
                'NR_GT' => null,
                'ID_MOEDA' => $request->id_moeda

            ]);

            $nr_rm = $request->nr_rm;
            $ano_rm = $request->ano_rm;
            $cd_centro = $request->cd_centro;

            alert()->success('Item incluído com Sucesso.', '');

            return redirect('item_req_material/' . $nr_rm . '/' . $ano_rm . '/' . $cd_centro . '/showItens');

        } catch (Exception $e) {
            return redirect('req_material')->with('error', 'Algo de errado aconteceu, por favor entre em contato com o NTI.');
        }
    }

    public function searchItem(Request $request)
    {

        $item = DB::table('estoque..MATERIAL')
            ->select(DB::raw('Convert(varchar(10),cd_almox)+CD_MATCAT+CD_INDMAT AS codigo,UNI_MATCAT 
                AS unidade, NM_MAT AS nome, convert(varchar(250),COMPL_MAT)'))
            ->where('ATIVO', 'S')
            ->where('NM_MAT', 'like', '%' . $request->q . '%')
            ->get();

        return response()->json($item);

    }

    public function getUnidade($codigo)
    {

        $unidade = DB::table('estoque..material')
            ->whereRaw('Convert(varchar(10),cd_almox)+CD_MATCAT+CD_INDMAT= ' . $codigo)
            ->select('uni_matcat as unidade')
            ->first();

        return response()->json($unidade);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showItens($nr_rm, $ano_rm, $cd_centro)
    {
        $aux = DB::table('REQUISICAO_MATERIAL')
            ->where('nr_rm', $nr_rm)
            ->where('ano_rm', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->first();

//        If verifica se o tipo da requisicao é de material ou de servico

        if ($aux->TP_RM == 1) {
            $tabela = $this->tabelaMaterial($nr_rm, $ano_rm, $cd_centro);
        } else {
            $tabela = $this->tabelaServico($nr_rm, $ano_rm, $cd_centro);
        }

        return view('item_req_material.showItens', compact('tabela', 'ano_rm', 'nr_rm', 'cd_centro'),
            ['tipo' => $aux->TP_RM]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $nr_rm , $ano_rm, $cd_centro
     * @return \Illuminate\Http\Response
     */
    public function editMaterial($nr_rm, $ano_rm, $cd_centro, $nr_item)
    {
        $item = DB::table('Item_rm')
            ->where('nr_rm', $nr_rm)
            ->where('ano_rm', $ano_rm)
            ->where('cd_centro', $cd_centro)
            ->where('nr_item', $nr_item)
            ->first();

        $material = DB::table('estoque..MATERIAL')
            ->select('nm_mat', 'uni_matcat')
            ->where('cd_almox', $item->CD_ALMOX)
            ->where('cd_matcat', $item->CD_MATCAT)
            ->where('cd_indmat', $item->CD_INDMAT)
            ->where('ATIVO', 'S')
            ->first();

        $ds_moeda = DB::table('difi..ac_moeda')
            ->select('ds_moeda')
            ->where('id_moeda', $item->ID_MOEDA)
            ->first();

        $moeda = DB::select('EXEC Proc_MoedaFrequente');

//        dd($item, $item, $ds_moeda);

        return view('item_req_material.editMaterial', compact('material', 'item', 'moeda', 'ds_moeda'));
    }

    public function editServico($nr_rm, $ano_rm, $cd_centro, $nr_item)
    {
        $item = DB::table('Item_rm')
            ->where('nr_rm', $nr_rm)
            ->where('ano_rm', $ano_rm)
            ->where('cd_centro', $cd_centro)
            ->where('nr_item', $nr_item)
            ->first();
//        dd($item);

        $ds_moeda = DB::table('difi..ac_moeda')
            ->select('ds_moeda')
            ->where('id_moeda', $item->ID_MOEDA)
            ->first();

        $moeda = DB::select('EXEC Proc_MoedaFrequente');

//        dd($item, $item, $ds_moeda);

        return view('item_req_material.editServico', compact('item', 'moeda', 'ds_moeda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateMaterial(Request $request, $id)
    {
        try {

            if ($request->vl_unit == "") {
                $request->id_moeda = null;
                $request->vl_unit = null;
            }

            $qt_item = str_replace(",", ".", $request->qt_item);

            DB::table('Item_Rm')
                ->where('NR_RM', $request->nr_rm)
                ->where('ANO_RM', $request->ano_rm)
                ->where('CD_CENTRO', $request->cd_centro)
                ->where('NR_ITEM', $id)
                ->update([

                    'CD_ALMOX' => $request->itemName[0],
                    'CD_MATCAT' => $request->itemName[1] . $request->itemName[2],
                    'CD_INDMAT' => $request->itemName[3] . $request->itemName[4] . $request->itemName[5] . $request->itemName[6] . $request->itemName[7],
                    'COMPL_ITEMRM' => $request->compl_itemrm,
                    'QT_ITEM' => $qt_item,
                    'VL_UNIT' => $request->vl_unit,
                    'ID_MOEDA' => $request->id_moeda

                ]);

            $nr_rm = $request->nr_rm;
            $ano_rm = $request->ano_rm;
            $cd_centro = $request->cd_centro;

            alert()->success('Registro Alterado com Sucesso.', '');

            return redirect('item_req_material/' . $nr_rm . '/' . $ano_rm . '/' . $cd_centro . '/showItens');

        } catch (Exception $e) {
            return redirect('req_material')->with('error', 'Algo de errado aconteceu, por favor entre em contato com o NTI.');
        }
    }

    public function updateServico(Request $request, $id)
    {
        try {

            if ($request->vl_unit == "") {
                $request->id_moeda = null;
                $request->vl_unit = null;
            }

            $qt_item = str_replace(",", ".", $request->qt_item);

            DB::table('Item_Rm')
                ->where('NR_RM', $request->nr_rm)
                ->where('ANO_RM', $request->ano_rm)
                ->where('CD_CENTRO', $request->cd_centro)
                ->where('NR_ITEM', $id)
                ->update([

                    'DS_SERV' => $request->ds_serv,
                    'COMPL_ITEMRM' => $request->compl_itemrm,
                    'QT_ITEM' => $qt_item,
                    'VL_UNIT' => $request->vl_unit,
                    'ID_MOEDA' => $request->id_moeda

                ]);

            $nr_rm = $request->nr_rm;
            $ano_rm = $request->ano_rm;
            $cd_centro = $request->cd_centro;

            alert()->success('Registro Alterado com Sucesso.', '');

            return redirect('item_req_material/' . $nr_rm . '/' . $ano_rm . '/' . $cd_centro . '/showItens');

        } catch (Exception $e) {
            return redirect('req_material')->with('error', 'Algo de errado aconteceu, por favor entre em contato com o NTI.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $nr_rm , $ano_rm, $cd_centro, $nr_item
     * @return \Illuminate\Http\Response
     */
    public function destroyMaterial($nr_rm, $ano_rm, $cd_centro, $nr_item)
    {

        DB::table('item_rm')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->delete();

        $this->ordenacaoItens($nr_rm, $ano_rm, $cd_centro);

        alert()->success('Registro Excluido com Sucesso.', '');

        return redirect('item_req_material/' . $nr_rm . '/' . $ano_rm . '/' . $cd_centro . '/showItens');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $nr_rm , $ano_rm, $cd_centro, $nr_item
     * @return \Illuminate\Http\Response
     */
    public function destroyServico($nr_rm, $ano_rm, $cd_centro, $nr_item)
    {

        DB::table('item_rm')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->delete();

        $this->ordenacaoItens($nr_rm, $ano_rm, $cd_centro);

        alert()->success('Registro Excluido com Sucesso.', '');

        return redirect('item_req_material/' . $nr_rm . '/' . $ano_rm . '/' . $cd_centro . '/showItens');

    }

    public function tabelaServico($nr_rm, $ano_rm, $cd_centro)
    {

        $tabela = DB::table('item_rm')
            ->leftJoin('DIFI..AC_MOEDA', 'DIFI..AC_MOEDA.ID_MOEDA', '=', 'item_rm.ID_MOEDA')
            ->where('nr_rm', $nr_rm)
            ->where('ano_rm', $ano_rm)
            ->where('cd_centro', $cd_centro)
            ->orderBy('item_rm.nr_item')
            ->get();

        return $tabela;

    }

    public function tabelaMaterial($nr_rm, $ano_rm, $cd_centro)
    {

        $tabela = DB::table('item_rm')
            ->join('estoque..material', 'estoque..material.CD_ALMOX', '=', 'item_rm.CD_ALMOX')
            ->leftJoin('DIFI..AC_MOEDA', 'DIFI..AC_MOEDA.ID_MOEDA', '=', 'item_rm.ID_MOEDA')
            ->whereRaw('estoque..material.CD_MATCAT = item_rm.CD_MATCAT')
            ->whereRaw('estoque..material.CD_INDMAT=item_rm.CD_INDMAT')
            ->where('nr_rm', $nr_rm)
            ->where('ano_rm', $ano_rm)
            ->where('cd_centro', $cd_centro)
            ->where('item_rm.CD_ALMOX', '!=', null)
            ->orderBy('item_rm.NR_ITEM')
            ->get();

        return $tabela;
    }

    public function ordenacaoItens($nr_rm, $ano_rm, $cd_centro){

        $aux = DB::table('item_rm')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->select('NR_ITEM')
            ->get();

        $numero_item = 1;

        foreach ($aux as $a){

            DB::table('item_rm')
                ->where('NR_RM', $nr_rm)
                ->where('ANO_RM', $ano_rm)
                ->where('CD_CENTRO', $cd_centro)
                ->where('NR_ITEM', $a->NR_ITEM)
                ->update([
                    'NR_ITEM' => $numero_item
                ]);
            $numero_item ++;
        }

    }

}
