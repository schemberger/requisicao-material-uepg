@extends('layouts.body')

@section('content')

    {!! Form::open(array('url' => 'item_req_material/material', 'class'=>'form-horizontal top', 'id' => 'signupForm')) !!}

    <fieldset>

        <input type="hidden" name="nr_rm" value="{{$nr_rm}}">
        <input type="hidden" name="ano_rm" value="{{$ano_rm}}">
        <input type="hidden" name="cd_centro" value="{{$cd_centro}}">

    {{--ajax select--}}
    <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Material</label>
            <div class="col-md-4">
                <select class="itemName form-control select" name="itemName"></select>
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="justificativa">Complemento</label>
            <div class="col-md-4">
                    <textarea class="form-control" id="compl_itemrm" name="compl_itemrm"
                              placeholder="Complemento"></textarea>
            </div>
            <div class="col-md-1"><span>* Opcional</span></div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Unidade</label>
            <div class="col-md-2">
                <input id="unidade" name="unidade" class="form-control input-md"
                       type="text" disabled>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Quantidade</label>
            <div class="col-md-2">
                <input id="qt_item" name="qt_item" placeholder="Quantidade"
                       class="form-control input-md" type="text">
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Valor Unitário</label>
            <div class="col-md-2">
                <input id="vl_unit" name="vl_unit" placeholder="Valor Unitário"
                       class="form-control input-md" type="text">
            </div>
        </div>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Moeda</label>
            <div class="col-md-2">
                <select name="id_moeda" id="id_moeda" class="form-control">
                    @foreach($moeda as $k)
                        <option value="{{$k->id_moeda}}">{{$k->ds_moeda}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <input type="hidden" id="descMaterial" name="descMaterial" value="">

        <input type="hidden" id="uni" name="uni" value="">


    {{--complemento box ckeditor--}}


    <!-- Button (Double) -->
        <div class="form-group" style="margin-top: 3%;">
            <div class="col-md-8 col-lg-offset-4">
                <button type="submit" id="button1id" name="button1id" class="btn btn-success">Inserir</button>
                <a href="{{url('req_material')}}" class="btn btn-primary">Imprimir</a>
                <a href="{{URL::previous()}}" class="btn btn-danger teste">Voltar</a>
            </div>
        </div>

    </fieldset>

    {!! Form::close() !!}

@stop

@section('end-script')

    <script type="text/javascript">
        $(function () {
            $("#vl_unit").maskMoney();
        })
    </script>

    <script>
        $(".delete").click(function (event) {
            event.preventDefault();

            var url = $(this).attr('href');

            console.log(url);

            swal({
                title: "Tem certeza?",
                text: "Você não será capaz de recuperar esse dado.",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#DD6B55",
                confirmButtonColor: "#5cb85c",
                confirmButtonText: "Confirmar",
                closeOnConfirm: false
            }, function (isConfirm) {
                if (!isConfirm) return;

                window.location.href = url;
            });
        });
    </script>

    <script type="text/javascript">

        $('.itemName').select2({
            placeholder: 'Selecione um material.',
            minimumInputLength: 3,
            ajax: {
                url: '{{url('/item_req_material/searchItem')}}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.nome + ' - ' + item.unidade,
                                id: item.codigo
                            }
                        })
                    };
                },
                cache: true
            }
        }).on("change", function (e) {

            var codigo = $(".itemName option:last-child").text();

            var aux = codigo.split(' - ');

            $('#unidade').val(aux[1]);

            $('#uni').val(aux[1]);

            $('#descMaterial').val(aux[0]);
        });

    </script>

    <script>
        $().ready(function () {

            var url = $(".teste").attr('href');

            var aux = url.substr(url.lastIndexOf('/') + 1);

            if(aux != 'showItens'){
                $(".teste").attr('href', '{{url('req_material')}}')
            }
        });
    </script>

    <script>

        $().ready(function () {

            $("#signupForm").validate({

                rules: {
                    qt_item: "required",
                    itemName: {required: true}
                },
                messages: {
                    qt_item: "O campo Quantidade é obrigatório.",
                    itemName: "O campo Material é obrigatório."
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    // Add the `help-block` class to the error element
                    error.addClass("help-block");

                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.parent("label"));
                    } else {
                        error.insertAfter(element);
                    }
                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.closest('.has-error').find('.select2'));
                    } else if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },

                highlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-2").addClass("has-error").removeClass("has-success");
                    $(element).parents(".col-md-4").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).parents(".col-md-2").addClass("has-success").removeClass("has-error");
                    $(element).parents(".col-md-4").addClass("has-success").removeClass("has-error");
                }
            });
        });

        // add valid and remove error classes on select2 element if valid
        $('.select').on('change', function () {
            if ($(this).valid()) {
                $(this).next('span').removeClass('error').addClass('valid');
            }
        });
    </script>

@endsection