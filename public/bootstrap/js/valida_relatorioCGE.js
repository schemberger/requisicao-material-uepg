$(document).ready(function () {
    $("#nrRelatorioCGE").on('change', function (e) {

        var nr = document.getElementById('nrRelatorioCGE').value;

        var ano = document.getElementById('nrAnoRelatorioCGE').value;

        valida(nr, ano);

    });

    $("#nrAnoRelatorioCGE").on('change', function (e) {

        var nr = document.getElementById('nrRelatorioCGE').value;

        var ano = document.getElementById('nrAnoRelatorioCGE').value;

        valida(nr, ano);
    });

    function valida(nr, ano) {

        var anoAtual = $.datepicker.formatDate('yy', new Date());

        if (nr) {
            $("#showmessageNR").hide();  //O Número do Relatório CGE é obrigatório.
            if(nr > 0){

                $("#showmessageNR1").hide();  //Número do Relatório CGE inválido.

                if (ano) {

//                            $("#showmessageNR").hide();  //O Número do Relatório CGE é obrigatório.
                    $("#showmessageANO1").hide();  //O Ano do Relatório CGE é obrigatório.

                    if (ano <= anoAtual && ano >= 2010) {

                        $("#showmessageANO").hide();  //Ano do Relatório inválido.

                        document.getElementById("button1id").disabled = false;

                    } else {
                        document.getElementById("button1id").disabled = true;
                        $("#showmessageANO").show();  //Ano do Relatório inválido.
                    }
                } else {
                    document.getElementById("button1id").disabled = true;
                    $("#showmessageANO1").show();  //Ano do Relatório CGE é obrigatório.
                }

            }else{
                if(ano){
                    if (ano <= anoAtual && ano >= 2010) {

                        $("#showmessageANO").hide();  //Ano do Relatório inválido.

                        document.getElementById("button1id").disabled = false;

                    } else {
                        document.getElementById("button1id").disabled = true;
                        $("#showmessageANO").show();  //Ano do Relatório inválido.
                    }
                }

                $("#showmessageNR1").show();  //Número do Relatório CGE inválido.
                document.getElementById("button1id").disabled = true;
            }

        } else {

            if (ano) {

                document.getElementById("button1id").disabled = true;
                $("#showmessageNR").show();  //O Número do Relatório CGE é obrigatório.

                if (ano > anoAtual || ano < 2010) {

                    document.getElementById("button1id").disabled = true;
                    $("#showmessageANO").show();  //Ano do Relatório CGE é obrigatório.

                } else {
                    $("#showmessageANO").hide();  //Ano do Relatório CGE é obrigatório.
                }
            }
            else {
                document.getElementById("button1id").disabled = false;
                $("#showmessageANO1").hide();  //O Ano do Relatório CGE é obrigatório.

                $("#showmessageNR").hide();  //O Número do Relatório CGE é obrigatório.

            }
        }
    }
});