/**
 * Created by schem on 02/02/2017.
 */

//Quando o campo cpf perde o foco.
$("#cep").blur(function () {

    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    if (cep != "") {

        $("#enderecoResp").val("...");

        var get_nameURL = $(this).attr('data-url') + '/' + cep;

        $.get(get_nameURL, function (data) {

            if (!("erro" in data) || data != "") {
                console.log(data[0]);

                //Atualiza os campos com os valores da consulta.
                $("#enderecoResp").val(data[0].NM_TIPO_LOGRADOURO + ' ' + data[0].DS_ENDERECO + ', ' + data[0].NM_BAIRRO + ' '
                    + data[0].NM_CIDADE + ' ' + data[0].UF_SIGLA);

            } else {
                alert("CEP não foi encontrado.");
            }
        });
    }
});


