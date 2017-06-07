<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Support\Facades\Input;

class ReqMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // para pegar o valor do ano acessar o banco e recuperar o ultimo ano da requisicao e fazer um ++ ate o ano atual

        $ano_rm = DB::table('Requisicao_Material')
            ->min('ano_rm');

        $ano_atual = date('Y');

        $nm_centro = $this->acesso();

        return view('req_material.index', compact('ano_rm', 'ano_atual', 'nm_centro'));
    }

    public function showTable($ano, $cd)
    {

        $tabela = DB::select(DB::raw('SELECT r.nr_rm, r.CD_CENTRO,r.dt_emissao,convert(VARCHAR(250),r.justifica) AS justificativa,CASE 
                    WHEN status = \'E\' THEN \'Emitido\' 
                    WHEN status = \'C\' THEN \'Cancelado\'
                    WHEN status = \'B\' THEN \'Baixado\'
                    WHEN status = NULL THEN \'Não Emitido\'
                END as situacao ,\'S\' AS orcamento
                 FROM REQUISICAO_MATERIAL r WHERE r.ANO_RM= \'' . $ano . '\' AND r.CD_CENTRO=\'' . $cd . '\'
                AND exists(SELECT 1 FROM QC_RM q WHERE q.nr_rm=r.nr_rm AND q.ano_rm=r.ano_rm AND q.cd_centro=r.cd_centro)
                UNION
                SELECT r.nr_rm, r.CD_CENTRO,r.dt_emissao,convert(VARCHAR(250),r.justifica) AS justificativa,CASE 
                    WHEN status = \'E\' THEN \'Emitido\' 
                    WHEN status = \'C\' THEN \'Cancelado\'
                    WHEN status = \'B\' THEN \'Baixado\'
                    WHEN status = NULL THEN \'Não Emitido\'
                END as situacao,\'N\' AS orcamento
                 FROM REQUISICAO_MATERIAL r WHERE r.ANO_RM= \'' . $ano . '\' AND r.CD_CENTRO = \'' . $cd . '\'
                AND NOT exists(SELECT 1 FROM QC_RM q WHERE q.nr_rm=r.nr_rm AND q.ano_rm=r.ano_rm AND q.cd_centro=r.cd_centro)
                ORDER BY r.nr_rm DESC'));

        // para pegar o valor do ano acessar o banco e recuperar o ultimo ano da requisicao e fazer um ++ ate o ano atual

        $ano_rm_min = DB::table('Requisicao_Material')
            ->min('ano_rm');

        $ano_atual = date('Y');

        $nm_centro = $this->acesso();

        // As 3 variaveis abaixo são utilizadas para mostrar no campo select os dados buscados na pag anterior

        $cd_centro = $cd;

        $ano_rm = $ano;

        $nm_centro_atual = DB::table('asseplan..centro_custo')
            ->where('cd_centro', $cd_centro)
            ->select('nm_centro')
            ->first();

        if (count($tabela)) {
            return view('req_material.showTable', compact('tabela', 'ano_atual', 'ano_rm_min', 'nm_centro', 'cd_centro',
                'ano_rm', 'nm_centro_atual'));
        } else {
            return redirect('req_material')->with('error', 'Nenhum registro foi encontrado.');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $aux = DB::table('requisicao_material')
            ->where('cd_centro', $id)
            ->where('ano_rm', date('Y'))
            ->orderBy('NR_RM', 'desc')
            ->first();

        if (count($aux)) {
//            dd($aux);
            $nr_rm = $aux->NR_RM + 1;
        } else {
            $nr_rm = 1;
        }

        $usuario = Auth::user()->username;

        //inicialmente usar usuario trrebonato para fazer busca
        $emissor = DB::table('acesso_g..usuario')
            ->where('cd_usuario', 'trrebonato')
            ->first();

        $fonte = DB::table('fonte')
            ->distinct('nm_fonte')
            ->where('cd_ativo', 'S')
            ->get();

        $orgao_dest = DB::table('asseplan..centro_custo')
            ->select('nm_centro', 'cd_centro')
            ->where('tp_ativ_dest', 'N')
            ->get();

        $orgao = DB::table('asseplan..centro_custo')
            ->where('cd_centro', $id)
            ->first();


        return view('req_material.form', compact('emissor', 'fonte', 'orgao_dest', 'orgao', 'nr_rm'));
    }

    public function receptores($cd_centro)
    {

        $receptores = DB::table('estoque..RECEPTOR_CC')
            ->select('RECEPTORES')
            ->where('cd_centro', $cd_centro)
            ->first();

        return response()->json($receptores);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request);

        $dt_emissao = explode('/', $request->dt_emissao, 3);

        try {

            if ($request->cd_fonte == "") {
                $request->cd_fonte = null;
            }

            DB::table('Requisicao_Material')->insert([

                'NR_RM' => $request->nr_rm,
                'ANO_RM' => $request->ano_rm,
                'CD_CENTRO' => $request->cd_centro,
                'TP_RM' => $request->tp_rm,
                'CD_CCDEST' => $request->cd_ccdest,
                'COMPL_DEST' => $request->compl_dest,
                'DT_EMISSAO' => $dt_emissao[2] . $dt_emissao[1] . $dt_emissao[0],
                'EMISSOR' => $request->emissor,
                'LOC_ENTRG' => $request->loc_entrg,
                'RECEPTOR' => $request->receptor,
                'JUSTIFICA' => $request->justifica,
                'OBS' => $request->obs,
                'STATUS' => null,
                'CD_FONTE' => $request->cd_fonte,
                'NR_CTAUEPG' => $request->nr_ctauepg

            ]);

            //Requisicao for do tipo Material

            alert()->success('Requisição incluida com Sucesso.', '');

            if ($request->tp_rm == 1) {
                return redirect('item_req_material/' . $request->nr_rm . '/' . $request->ano_rm . '/' . $request->cd_centro . '/createMaterial');
            } else {
                return redirect('item_req_material/' . $request->nr_rm . '/' . $request->ano_rm . '/' . $request->cd_centro . '/createServico');
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
    public function show($nr_rm, $ano_rm, $cd_centro)
    {
        $requisicao = DB::table('REQUISICAO_MATERIAL')
            ->where('nr_rm', $nr_rm)
            ->where('ano_rm', $ano_rm)
            ->where('CD_CENTRO', $cd_centro)
            ->first();

        $orgao = DB::table('asseplan..centro_custo')
            ->where('cd_centro', $cd_centro)
            ->first();

        $orgao_dest = DB::table('asseplan..centro_custo')
            ->where('cd_centro', $requisicao->CD_CCDEST)
            ->first();

        $fonte = DB::table('fonte')
            ->distinct('nm_fonte')
            ->where('cd_fonte', $requisicao->CD_FONTE)
            ->get();

//        dd($fonte);

//        dd($requisicao, $orgao, $orgao_dest);

        //        If verifica se o tipo da requisicao é de material ou de servico

        $item = new ItemReqMaterialController();

        if ($requisicao->TP_RM == 1) {
            $tabela = $item->tabelaMaterial($nr_rm, $ano_rm, $cd_centro);
        } else {
            $tabela = $item->tabelaServico($nr_rm, $ano_rm, $cd_centro);
        }

        return view('req_material.visualizar', compact('requisicao', 'orgao_dest', 'orgao', 'tabela', 'fonte'),
            ['tipo' => $requisicao->TP_RM]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $data, $cd_centro)
    {

        $requisicao = DB::table('REQUISICAO_MATERIAL')
            ->where('nr_rm', $id)
            ->where('ano_rm', $data)
            ->where('CD_CENTRO', $cd_centro)
            ->first();

        $orgao = DB::table('asseplan..centro_custo')
            ->where('cd_centro', $cd_centro)
            ->first();

        $orgao_dest = DB::table('asseplan..centro_custo')
            ->select('nm_centro', 'cd_centro')
            ->where('tp_ativ_dest', 'N')
            ->get();

        $orgao_dest_aux = DB::table('asseplan..centro_custo')
            ->where('cd_centro', $requisicao->CD_CCDEST)
            ->first();

        $receptores = DB::table('estoque..RECEPTOR_CC')
            ->select('RECEPTORES')
            ->where('cd_centro', $requisicao->CD_CCDEST)
            ->first();

        $fonte = DB::table('fonte')
            ->distinct('nm_fonte')
            ->where('cd_ativo', 'S')
            ->get();

        $fonte_aux = DB::table('fonte')
            ->distinct('nm_fonte')
            ->where('cd_fonte', $requisicao->CD_FONTE)
            ->where('cd_ativo', 'S')
            ->get();

        $usuario = Auth::user()->username;

        //inicialmente usar usuario trrebonato para fazer busca
        $emissor = DB::table('acesso_g..usuario')
            ->where('cd_usuario', 'trrebonato')
            ->first();

        $item_rm = DB::table('Item_rm')
            ->where('nr_rm', $requisicao->NR_RM)
            ->where('ano_rm', $requisicao->ANO_RM)
            ->where('cd_centro', $requisicao->CD_CENTRO)
            ->get();

        //if = true significa que ja possui itens cadastrados nessa RM, portanto nao sendo possivel alterar de servico para material
//        ou o contrario
        if (count($item_rm)) {
            $opcao_tipo_requisicao = "bloqueado";
        } else {
            $opcao_tipo_requisicao = "liberado";
        }

        $cd_centro = $cd_centro;
        $ano_rm = $data;
        $nr_rm = $id;

        return view('req_material.edit', compact('requisicao', 'orgao', 'orgao_dest', 'fonte', 'fonte_aux',
            'emissor', 'orgao_dest_aux', 'receptores', 'cd_centro', 'ano_rm', 'nr_rm', 'opcao_tipo_requisicao'));

    }

    public function validationEdit($nr_rm, $dt_emissao, $cd_centro)
    {

        $aux = DB::table('QC_RM')
            ->where('nr_rm', $nr_rm)
            ->where('ano_rm', $dt_emissao)
            ->where('CD_CENTRO', $cd_centro)
            ->first();

        if (count($aux)) {
            return response()->json(array('msg' => 'O registro não pode ser Editado pois esta em processo de Orçamento', 'status' => 'Error'));
        } else {
            return response()->json(array('status' => 'ok'));
        }
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
//        dd($request);

        if ($request->cd_fonte == "") {
            $request->cd_fonte = null;
        }

        try {

            DB::table('Requisicao_Material')
                ->where('NR_RM', $id)
                ->where('ANO_RM', $request->ano_rm)
                ->where('CD_CENTRO', $request->cd_centro)
                ->update([

                    'TP_RM' => $request->tp_rm,
                    'CD_CCDEST' => $request->cd_ccdest,
                    'COMPL_DEST' => $request->compl_dest,
                    'LOC_ENTRG' => $request->loc_entrg,
                    'RECEPTOR' => $request->receptor,
                    'JUSTIFICA' => $request->justifica,
                    'OBS' => $request->obs,
                    'CD_FONTE' => $request->cd_fonte,
                    'NR_CTAUEPG' => $request->nr_ctauepg

                ]);

            alert()->success('Requisição alterada com Sucesso.', '');

            return redirect('req_material/showTable/' . $request->ano_rm . '/' . $request->cd_centro);

        } catch (Exception $e) {
            return redirect('req_material')->with('error', 'Algo de errado aconteceu, por favor entre em contato com o NTI.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $data, $cd_centro)
    {
        $aux = DB::table('QC_RM')
            ->where('nr_rm', $id)
            ->where('ano_rm', $data)
            ->where('CD_CENTRO', $cd_centro)
            ->first();

        if (count($aux)) {
            return response()->json(array('msg' => 'O registro não pode ser excluido pois esta em processo de Orçamento', 'status' => 'Error'));
        } else {

            DB::table('REQUISICAO_MATERIAL')
                ->where('NR_RM', $id)
                ->where('ANO_RM', $data)
                ->where('CD_CENTRO', $cd_centro)
                ->delete();

            return response()->json(array('msg' => 'Requisição deletada com sucesso.', 'status' => 'Success'));
        }
    }

    public function acesso()
    {
        $usuario = Auth::user()->username;

        $acesso = DB::select('EXEC acesso_g..ver_acessos_nivel ?, ?, ?, ?, ?', array('Compras', '', '', 'trrebonato', 0));

        //select abaixo sera utilizado quando subir pra prod, enquanto estiver em testes usar usuario trrebonato
//        $acesso = DB::select('EXEC acesso_g..ver_acessos_nivel ?, ?, ?, ?, ?', array('Compras', '', '', $usuario, 0));

        if (count($acesso)) {

            $nm_centro = array();

            foreach ($acesso as $i => $aux) {

                $nm_centro[] = DB::table('asseplan..centro_custo')
                    ->where('cd_centro', $aux->nivel_acesso)
                    ->first();
            }
            return $nm_centro;
        } else {
            $nm_centro = DD::table('asseplan..centro_custo')
                ->select('nm_centro')
                ->where('tp_ativ_dest', 'N')
                ->get();

            return $nm_centro;
        }
    }

    public function duplicar($nr_rm, $ano_rm, $cd_centro){
        //muda numero, ano, situcao = null, e pessoa que esta criando req
    }
}
