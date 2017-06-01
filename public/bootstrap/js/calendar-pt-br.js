$(function() {

    var year = document.getElementById('ano').value;

    $("#datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        minDate: new Date(year, 0, 1),
        maxDate: new Date(year, 11, 31)

    })
});

$(document).ready(function(){


    $(".monthPicker").datepicker({
        dateFormat: 'mm-yy',
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        changeMonth: true,
        changeYear: true,
        showButtonPanel: false,


    });
    $(".monthPicker").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });
})