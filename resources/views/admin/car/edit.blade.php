@extends('layouts.admin')
@section('content')

@section('header')
<title>{{Lang::get('messages.name')}}</title> 
<style>
    
    a {
        color: #212529;
        text-decoration: none;
    }

</style>
@endsection
@section('scriptFile')

<script type="text/javascript" src="{{asset('public/js/vendor/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
@if(App::isLocale('fr'))
<script type="text/javascript" src="{{asset('public/js/vendor/bootstrapvalidator/js/fr_FR.js')}}"></script>
@endif

<?php
$model = $car->modele;
?>
<script>

function getListModelByBrand(idbrand) {
    $.ajax({
        url: "{{Config::get('app.url')}}" + "model/list",
        type: "GET",
        data: {
            "idbrand": idbrand,
        },
        success: function (data) {
            console.log(JSON.stringify(data));
            var model_options = "<option value=''>{{ Lang::get('messages.select')}}</option>";
            $.each(data.data, function (index, modele) {
                model_options += "<option value='" + modele.id + "'>" + modele.name + "</option>";
            });
            $(".idmodel").html(model_options);
        },
        error: function (result) {
          
        },
        complete: function () {
        }

    });
}

$(document).ready(function () {

    $(".idbrand").on("change", function () {
        var idbrand = $(this).val();
        $(".idmodel").html("<option value=''>{{ Lang::get('messages.select')}}</option>");
        if (idbrand != "0" && idbrand != "") {
            $(".car_name").val($(".idbrand option:selected").text());
            getListModelByBrand(idbrand);
        }
    });
    
    $(".idmodel").on("change", function () {
        var idmodel = $(this).val();
        if (idmodel != "0" && idmodel != "") {
            $(".car_name").val($(".idbrand option:selected").text() + " " + $(".idmodel option:selected").text());
        }
    });
    
});

</script>
@endsection

@section('content')

<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{Lang::get('messages.menu.admin.car.edit')}}</h2>

                        <div class="clearfix"></div>
                    </div>


                    <div class="x_content">
                        <br>

                        {{ Form::open(array('url' => '/admin/car/edit ',"class"=>"form-horizontal form-label-left","id"=>"editForm")) }}
                        <div class="col-md-4">

                            <div class="form-group ">
                                <label >{{Lang::get('messages.menu.admin.car.brand')}}</label>
                                {{ Form::select('idbrand', $brands,$car->idbrand,array('class' => 'idbrand form-control','data-bv-notempty'=>'true')) }}

                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group ">
                                <label >{{Lang::get('messages.menu.admin.car.model')}}</label>
                                {{ Form::select('idmodel',$models,$car->idmodel,array('class' => ' idmodel form-control','data-bv-notempty'=>'true')) }}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" name="id"  value="{{$car->id}}">  
                        <div class="clearfix col-md-12">
                            <div class="ln_solid"></div>
                            <div class="col-md-6 col-sm-6 ">
                                <a class="btn cancel" href="{{url('/admin/car')}}">
                                    <i class="fa fa-times-circle"></i> {{Lang::get('buttons.cancel')}}
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-6 ">

                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check-circle"></i> {{Lang::get('buttons.valid')}}</button>
                            </div>
                        </div>
                        <input type="text" value="{{$car->name}}" name="name"  data-bv-notempty="true" class="form-control hidden car_name">       
                        {{ Form::close() }}
                    </div>







                </div>
            </div>
        </div>


    </div>
</div>

@endsection