@extends('layouts.admin')
@section('content')

@section('header')
<title>{{Lang::get('messages.name')}}</title> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>
    
    a {
        color: #212529;
        text-decoration: none;
    }

</style>
@endsection
@section('scriptFile')

<link rel="stylesheet" href="{{asset('admin/vendors/bootstrap-table/js/bootstrap-table.min.js')}}">
@if(App::isLocale('fr'))
<link rel="stylesheet" href="{{asset('admin/vendors/bootstrap-table/js/bootstrap-table-fr-FR.js')}}">
@endif
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer ></script>

<script>



$(document).ready(function () {
    $('#brands-table').DataTable({
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
   
    
});

</script>
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{Lang::get('messages.menu.admin.brand.list')}}</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
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
               <div class="x_panel">

                    <div class="x_content">

                        <a href="{{url('/admin/brand/add')}}" class="pull-right">
                            <button type="button" class="btn btn-success btn-secondary "><i class="fa fa-plus-circle"></i> {{Lang::get('buttons.add')}}</button>
                        </a>
                        <div class="x_content table-responsive-md" style="display: block;">


                            <table id="brands-table" data-height="25" data-search="true" data-show-columns="true" data-pagination="true" class="table table-striped table-bordered" style="width:100%;">
                                <thead>
                                    <tr>

                                        <th>{{Lang::get('messages.menu.admin.car.brand')}}</th>
                                        <th>{{Lang::get('messages.menu.admin.car.nbr')}}</th>
                                        <th>{{Lang::get('messages.menu.admin.model.nbr')}}</th>
                                        <th>{{Lang::get('messages.menu.admin.model.date')}}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $brand) 
                                    <?php
                                    $origDate = $brand->created_at;

                                    $created_date = date("m-d-Y", strtotime($origDate));
                                    ?>
                                    <tr>

                                        <td> <div class="accordion-heading country">
                                                <a class="accordion-toggle" data-toggle="collapse" >{{$brand->name}}</a>
                                            </div>
                                        </td>
                                         <td>@foreach ($list_car as $car)
                                            @if($car->idbrand==$brand->id)<span>{{$car->nbre_car}}</span> @endif
                                            @endforeach </td>
                                            <td>@foreach ($list_model as $model)
                                                @if($model->idbrand==$brand->id)<span>{{$model->nbre_model}}</span>@endif
                                            @endforeach </td>
                                        <td>{{$created_date}}</td>
                                        <td>
                                            <a href="{{url('/admin/brand/'.$brand->id.'/edit')}}" class="btn btn-info btn-xs" data-placement="right" data-toggle="tooltip" title="Modifier"><i class="fa fa-pencil"></i>  </a>
                                            {{ Form::open(array('url' => '/admin/brand/delete',"class"=>"form-horizontal","data-placement"=>"right","data-toggle"=>"tooltip","title"=>"Supprimer","id"=>"addForm","enctype"=>"multipart/form-data")) }}
                                            <button type="submit" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i> </button>
                                              <input type="hidden" name="id"  value="{{$brand->id}}">  
                                              {{ Form::close() }}
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
</div>
@endsection