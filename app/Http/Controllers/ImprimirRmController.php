<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;

class ImprimirRmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($nr_rm, $ano_rm, $cd_centro)
    {

        $requisicao = DB::table('REQUISICAO_MATERIAL')
            ->where('nr_rm', $nr_rm)
            ->where('ano_rm', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->first();

        $orgao = DB::table('asseplan..centro_custo')
            ->where('cd_centro', $cd_centro)
            ->first();

        $orgao_destino = DB::table('asseplan..centro_custo')
            ->where('cd_centro', $requisicao->CD_CCDEST)
            ->first();

        $item = $this->tabelaMaterial($nr_rm, $ano_rm, $cd_centro);

//        dd($requisicao, $orgao_destino, $orgao, $item);


        $pdf = PDF::loadView('imprimirRm.material', compact('requisicao', 'orgao_destino', 'item'))
            ->setOption('header-html', view('layouts.relatorio.header', compact('requisicao', 'orgao')))
            ->setOption('header-spacing', 6)
            ->setOption('footer-html', view('layouts.relatorio.footer'))
            ->setOption('footer-spacing', 6)
            ->setOption('margin-bottom', 27)
            ->setPaper('A4');

        return $pdf->inline();
//        return view('imprimirRm.material', compact('requisicao'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
            ->orderBy('estoque..material.NM_MAT')
            ->get();

        return $tabela;
    }
}
