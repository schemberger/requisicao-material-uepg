/**
 * Created by schem on 02/02/2017.
 */
function limpa_formulário_cpf() {
// Limpa valores do formulário de cpf.
    $("#nomeResp").val("");
    $("#cep").val("");
    $("#enderecoResp").val("");
}

//Quando o campo cpf perde o foco.
$("#cpf").blur(function () {

    //Nova variável "cpf" somente com dígitos.
    var cpf = $(this).val().replace(/\D/g, '');

    if (cpf != "") {

        //imagem loagin.gif enquanto faz a requisicao ajax
        $("#loadingmessage").show();

        //Preenche os campos com "..." enquanto consulta webservice.
        $("#nomeResp").val("...");
        $("#cep").val("...");
        $("#enderecoResp").val("...");

        var get_nameURL = $(this).attr('data-url')+'/'+cpf;

        $.get(get_nameURL, function (data) {

            if (data[0].computed0 != null) {

                //Atualiza os campos com os valores da consulta.
                $("#nomeResp").val(data[0].computed0);
                $("#cep").val(data[0].computed2);
                $("#enderecoResp").val(data[0].computed1);

                $('#loadingmessage').hide(); // hide the loading message
            }else{
                alert("Cpf não foi encontrado.");
                $('#loadingmessage').hide(); // hide the loading message
                limpa_formulário_cpf();
            }

        });
    }
});


