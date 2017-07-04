<?php

namespace App\Http\Controllers;

use function GuzzleHttp\Psr7\copy_to_stream;
use Illuminate\Http\Request;
use DB;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($nr_rm, $ano_rm, $cd_centro, $nr_item)
    {
        $aux = DB::table('Item_RmDest')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->get();

        if (count($aux)) {

            $tabela = DB::table('item_rm')
                ->join('estoque..material', 'estoque..material.CD_ALMOX', '=', 'item_rm.CD_ALMOX')
                ->join('Item_RmDest', 'Item_RmDest.NR_RM', '=', 'Item_Rm.NR_RM')
                ->join('ASSEPLAN..CENTRO_CUSTO', 'ASSEPLAN..CENTRO_CUSTO.CD_CENTRO', '=', 'Item_RmDest.CD_CCDEST')
                ->whereRaw('estoque..material.CD_MATCAT = item_rm.CD_MATCAT')
                ->whereRaw('estoque..material.CD_INDMAT = item_rm.CD_INDMAT')
                ->whereraw('Item_RmDest.ANO_RM = Item_Rm.ANO_RM')
                ->whereraw('Item_RmDest.CD_CENTRO = Item_Rm.CD_CENTRO')
                ->where('Item_Rm.NR_ITEM', $nr_item)
                ->where('Item_Rm.ANO_RM', $ano_rm)
                ->where('Item_Rm.CD_CENTRO', $cd_centro)
                ->where('Item_Rm.NR_RM', $nr_rm)
                ->select('estoque..MATERIAL.nm_mat', 'ASSEPLAN..CENTRO_CUSTO.nm_centro', 'Item_RmDest.QT_ITEMD', 'Item_Rm.NR_ITEM',
                    'Item_Rm.ANO_RM', 'Item_Rm.CD_CENTRO', 'Item_Rm.NR_ITEM', 'Item_RmDest.NR_ITEM_DESTINO')
                ->orderBy('Item_RmDest.NR_ITEM_DESTINO')
                ->get();

//            dd($tabela);

            return view('destino.index', compact('tabela', 'nr_item', 'nr_rm', 'ano_rm', 'cd_centro'));
        } else {
            return $this->create($nr_rm, $ano_rm, $cd_centro, $nr_item);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($nr_rm, $ano_rm, $cd_centro, $nr_item)
    {
        $item = DB::table('Item_Rm')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->first();

//        $material = DB::table('estoque..MATERIAL')
//            ->select('nm_mat', 'uni_matcat')
//            ->where('cd_almox', $item->CD_ALMOX)
//            ->where('cd_matcat', $item->CD_MATCAT)
//            ->where('cd_indmat', $item->CD_INDMAT)
//            ->where('ATIVO', 'S')
//            ->first();

        $orgao_dest = DB::table('ASSEPLAN..CENTRO_CUSTO')
            ->where('tp_ativ_dest', 'N')
            ->get();

        $local_entrega = DB::table('LOCAL')
            ->where('CD_CENTRO', $cd_centro)
            ->get();

        $destino = DB::table('Item_RmDest')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->get();

        $quantidade_restante = $item->QT_ITEM;

        if (count($destino)) {
            foreach ($destino as $aux) {
                $quantidade_restante -= $aux->QT_ITEMD;
            }
            return view('destino.form', compact('item', 'orgao_dest', 'local_entrega', 'quantidade_restante'));
        }

        return view('destino.form', compact('item', 'orgao_dest', 'local_entrega', 'quantidade_restante'));
    }

    public function validationNovo($nr_rm, $ano_rm, $cd_centro, $nr_item)
    {
        $item = DB::table('Item_Rm')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->first();

        $destino = DB::table('Item_RmDest')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->get();

        $quantidade_final = 0;

        foreach ($destino as $aux) {
            $quantidade_final += $aux->QT_ITEMD;
        }

        if ($quantidade_final < $item->QT_ITEM) {
            return response()->json('success');
        } else {
            return response()->json('error');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aux = DB::table('Item_RmDest')
//            ->select('nr_item')
            ->where('nr_rm', $request->nr_rm)
            ->where('ano_rm', $request->ano_rm)
            ->where('cd_centro', $request->cd_centro)
            ->orderBy('nr_item', 'desc')
            ->first();

        if (count($aux)) {
            $nr_item_destino = $aux->NR_ITEM_DESTINO + 1;

        } else {
            $nr_item_destino = 1;
        }

        try {

            DB::table('Item_RmDest')->insert([

                'NR_ITEM_DESTINO' => $nr_item_destino,
                'NR_RM' => $request->nr_rm,
                'ANO_RM' => $request->ano_rm,
                'CD_CENTRO' => $request->cd_centro,
                'NR_ITEM' => $request->nr_item,
                'CD_CCDEST' => $request->cd_ccdest,
                'CD_LOCAL' => $request->cd_local,
                'COMPL_DESTRMD' => $request->compl_destrmd,
                'QT_ITEMD' => $request->qt_itemd,
                'NR_CTAUEPG' => $request->nr_ctauepg

            ]);

            $item = DB::table('Item_Rm')
                ->where('NR_RM', $request->nr_rm)
                ->where('ANO_RM', $request->ano_rm)
                ->where('CD_CENTRO', $request->cd_centro)
                ->where('NR_ITEM', $request->nr_item)
                ->first();

            $destino = DB::table('Item_RmDest')
                ->where('NR_RM', $request->nr_rm)
                ->where('ANO_RM', $request->ano_rm)
                ->where('CD_CENTRO', $request->cd_centro)
                ->where('NR_ITEM', $request->nr_item)
                ->get();

            $quantidade_restante = $item->QT_ITEM;

            foreach ($destino as $aux) {
                $quantidade_restante -= $aux->QT_ITEMD;
            }

            if ($item->QT_ITEM > $request->qt_itemd) {

                alert()->success('Restam ' . $quantidade_restante . ' unidades para cadastrar o destino', '');

                return redirect('destino/' . $request->nr_rm . '/' . $request->ano_rm . '/' . $request->cd_centro . '/' . $request->nr_item);

            } else {

                alert()->success('Destino incluído com Sucesso.', '');

                return redirect('item_req_material/' . $request->nr_rm . '/' . $request->ano_rm . '/' . $request->cd_centro . '/showItens');

            }

        } catch (Exception $e) {
            return redirect('req_material')->with('error', 'Algo de errado aconteceu, por favor entre em contato com o NTI.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($nr_rm, $ano_rm, $cd_centro, $nr_item)
    {
        $destino = DB::table('Item_RmDest')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->first();
//        dd($destino);

        $orgao_dest_atual = DB::table('ASSEPLAN..CENTRO_CUSTO')
            ->where('CD_CENTRO', $destino->CD_CCDEST)
            ->first();

        $local_entrega_atual = DB::table('LOCAL')
            ->where('CD_CENTRO', $cd_centro)
            ->where('CD_LOCAL', $destino->CD_LOCAL)
            ->first();

        $orgao_dest = DB::table('ASSEPLAN..CENTRO_CUSTO')
            ->where('tp_ativ_dest', 'N')
            ->get();

        $local_entrega = DB::table('LOCAL')
            ->where('CD_CENTRO', $cd_centro)
            ->get();

        $item = DB::table('Item_Rm')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->first();

        return view('destino.edit', compact('destino', 'orgao_dest',
            'local_entrega', 'orgao_dest_atual', 'local_entrega_atual', 'item'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        try {

            DB::table('Item_RmDest')
                ->where('NR_RM', $request->nr_rm)
                ->where('ANO_RM', $request->ano_rm)
                ->where('CD_CENTRO', $request->cd_centro)
                ->where('NR_ITEM', $request->nr_item)
                ->where('NR_ITEM_DESTINO', $id)
                ->update([

                    'CD_CCDEST' => $request->cd_ccdest,
                    'CD_LOCAL' => $request->cd_local,
                    'COMPL_DESTRMD' => $request->compl_destrmd,
                    'QT_ITEMD' => $request->qt_itemd,
                    'NR_CTAUEPG' => $request->nr_ctauepg

                ]);

            alert()->success('Destino Alterado com Sucesso.', '');

            return redirect('destino/' . $request->nr_rm . '/' . $request->ano_rm . '/' . $request->cd_centro . '/' . $request->nr_item);

        } catch (Exception $e) {
            return redirect('destino/' . $request->nr_rm . '/' . $request->ano_rm . '/' . $request->cd_centro . '/' . $request->nr_item)
                ->with('error', 'Algo de errado aconteceu, por favor entre em contato com o NTI.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($nr_rm, $ano_rm, $cd_centro, $nr_item, $nr_item_destino)
    {
        DB::table('Item_RmDest')
            ->where('NR_RM', $nr_rm)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->where('NR_ITEM_DESTINO', $nr_item_destino)
            ->delete();

        return response()->json(array('msg' => 'Registro deletada com sucesso.', 'status' => 'Success'));
    }
}
