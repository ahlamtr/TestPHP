@extends('layouts.admin')
@section('content')

@section('header')
<title>{{Lang::get('messages.name')}}</title> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection
@section('scriptFile')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js"></script>
@if(App::isLocale('fr'))
<link rel="stylesheet" href="{{asset('admin/vendors/bootstrap-table/js/bootstrap-table-fr-FR.js')}}">
@endif
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>

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
    $('#cars_table').DataTable({
        "language": {
            "sEmptyTable": "{{Lang::get('pagination.sEmptyTable')}}",
            "sInfo": "{{Lang::get('pagination.sInfo')}}",
            "sInfoEmpty": "{{Lang::get('pagination.sInfoEmpty')}}",
            "sInfoFiltered": "{{Lang::get('pagination.sInfoFiltered')}}",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": "{{Lang::get('pagination.sLengthMenu')}}",
            "sLoadingRecords": "{{Lang::get('pagination.sLoadingRecords')}}",
            "sProcessing": "{{Lang::get('pagination.sProcessing')}}",
            "sSearch": "{{Lang::get('pagination.sSearch')}}",
            "sZeroRecords": "{{Lang::get('pagination.sZeroRecords')}}",
            "oPaginate": {
                "sFirst": "{{Lang::get('pagination.sFirst')}}",
                "sLast": "{{Lang::get('pagination.sLast')}}",
                "sNext": "{{Lang::get('pagination.sNext')}}",
                "sPrevious": "{{Lang::get('pagination.sPrevious')}}"
            },
            "oAria": {
                "sSortAscending": "{{Lang::get('pagination.sSortAscending')}}",
                "sSortDescending": "{{Lang::get('pagination.sSortDescending')}}"
            },
            "select": {
                "rows": {
                    "_": "{{Lang::get('pagination.ligne')}}",
                    "0": "{{Lang::get('pagination.aucun')}}",
                    "1": "{{Lang::get('pagination.select')}}"
                }
            }
        },
        "ordering": false

    });

    $('#addForm').bootstrapValidator({
        feedbackIcons: {
            valid: '',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
        }
    });
   
    $(".idbrand").on("change", function () {
        var idbrand = $(this).val();
        $(".idmodel").html("<option value=''>{{ Lang::get('messages.select')}}</option>");
        if (idbrand != "0" && idbrand != "") {
            getListModelByBrand(idbrand);
        }
    });
});

</script>
@endsection

@section('content')
<?php
$idbrand = "";
$idmodel = "";
if (Session::has("search_admin")) {
    if (Session::has("idbrand")) {
        $idbrand = Session::get("idbrand");
    }
    if (Session::has("idmodel")) {
        $idmodel = Session::get("idmodel");
    }
}
?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{Lang::get('messages.menu.admin.car.list')}}</h3>
            </div>

        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                @if(Session::has("success"))
                <div class="alert alert-success " >
                    <strong>{{Lang::get("validation.success")}}</strong> {{Session::get("success_text")}}
                </div>
                <div class="clearfix"></div>
                @endif
                @if(Session::has("error"))
                <div class="alert alert-danger ">
                    <strong>{{Lang::get("validation.error")}}</strong> {{Session::get("error_text")}}
                </div>
                <div class="clearfix"></div>
                @endif
                @if(isset($echou) && ($echou ==true) && isset($msg))
                <div class="alert alert-danger ">
                    <strong>{{Lang::get("validation.error")}}</strong> {{$msg}}
                </div>
                <div class="clearfix"></div>
                @endif
               
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{Lang::get('messages.menu.admin.car.search')}} </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        {{ Form::open(array('url' => '/admin/car/search',"class"=>"form-horizontal form-label-left","id"=>"addForm","enctype"=>"multipart/form-data")) }}
                        <div class="col-md-6 ">

                            <div class="form-group ">
                                <label >{{Lang::get('messages.menu.admin.car.brand')}}</label>
                                {{ Form::select('idbrand', $list,'',array('class' => 'form-control idbrand','data-bv-notempty'=>'true',"data-bv-greaterthan-value"=>"1",'data-bv-feedbackicons'=>'false')) }}
                            </div>
                        </div>
                        <div class="col-md-6 clearfix">

                            <div class="form-group ">
                                <label >{{Lang::get('messages.menu.admin.car.model')}}</label>
                                {{ Form::select('idmodel', array(""=>Lang::get("messages.select")),'',array('class' => 'form-control idmodel','data-bv-notempty'=>'true',"data-bv-greaterthan-value"=>"1",'data-bv-feedbackicons'=>'false')) }}
                            </div>
                        </div>
                        
                        <div class="col-md-12 ">
                            <div class="ln_solid"></div>
                            <div class="col-md-6 col-sm-6 ">
                                <a class="btn cancel" href="#">
                                    <i class="fa fa-times-circle"></i> {{Lang::get('buttons.cancel')}}
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-6 ">
                                <button  type="submit" class="btn btn-success pull-right" ><i class="fa fa-search"></i>  {{Lang::get('buttons.search')}}</button>
                            </div>

                        </div>
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">

                    <div class="x_content table-responsive-md">


                        <a href="{{url('/admin/car/add')}}" style="display: block;" class="pull-right">
                            <button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> {{Lang::get('buttons.add')}}</button>
                        </a>
                        <br>
                        <table id="cars_table" class="table table-striped table-bordered " style="width:100%;">
                            <thead>
                                <tr>

                                    <th>{{Lang::get('messages.menu.admin.car.name')}}</th>
                                    <th>{{Lang::get('messages.menu.admin.car.brand')}}</th>
                                    <th>{{Lang::get('messages.menu.admin.car.model')}}</th>
                                    <th style="width: 20%">#Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_car as $car) 
                                <?php
                                $id = Hashids::encode($car->id);
                                ?>
                                <tr>
                                    <td>
                                        <a>{{$car->name}}</a>
                                    <td>
                                        <a>{{$car->brand}}</a>
                                    </td>
                                    </td>
                                    <td>
                                        <a>{{$car->modele}}</a>
                                    </td>
                                   
                                    <td style="width: 15%;">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col">
                                                    <a href="{{url('/admin/car/view?cid='.$id)}}" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" title="Consulter"><i class="fa fa-folder"></i>  </a>
                                                </div>
                                                {{ Form::open(array('url' => '/admin/car/delete ',"class"=>"form-horizontal form-label-left","id"=>"deleteForm")) }}
                                                <div class="col">
                                                    <button class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" title="Supprimer"><i class="fa fa-trash"></i>  </button>
                                                </div>
                                                <input type="hidden" name="id"  value="{{$car->id}}"> 
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </td> 
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection