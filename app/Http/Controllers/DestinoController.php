<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $ano_rm, $cd_centro, $nr_item)
    {
        $aux = DB::table('Item_RmDest')
            ->where('NR_RM', $id)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->get();

        $item = DB::table('Item_Rm')
            ->where('NR_RM', $id)
            ->where('ANO_RM', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->where('NR_ITEM', $nr_item)
            ->first();

        $orgao_dest = DB::table('ASSEPLAN..CENTRO_CUSTO')
            ->where('tp_ativ_dest', 'N')
            ->get();

        $local_entrega = DB::table('LOCAL')
            ->where('CD_CENTRO', $cd_centro)
            ->get();

        if($aux){
            foreach ($aux as $aux){
                $orgao_dest = DB::table('ASSEPLAN..CENTRO_CUSTO')
                    ->where('CD_CENTRO', $aux->CD_CCDEST)
                    ->first();
            }
            dd($orgao_dest);


            return view('destino.index', compact('aux'));
        }else{
            return view('destino.form', compact('item', 'orgao_dest', 'local_entrega'));
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            DB::table('Item_RmDest')->insert([

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

            $restante = $item->QT_ITEM - $request->qt_itemd;

            if($item->QT_ITEM > $request->qt_itemd){

                alert()->success('Restam '.$restante. ' unidades para cadastrar o destino', '');

                return redirect('destino/'.$request->nr_rm .'/'. $request->ano_rm.'/'.$request->cd_centro.'/'.$request->nr_item);

            }else{

                alert()->success('Destino incluído com Sucesso.', '');

                return redirect('item_req_material/'.$request->nr_rm .'/'. $request->ano_rm.'/'.$request->cd_centro.'/showItens');

            }



        } catch (Exception $e) {
            return redirect('req_material')->with('error', 'Algo de errado aconteceu, por favor entre em contato com o NTI.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
