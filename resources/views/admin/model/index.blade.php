@extends('layouts.admin')
@section('content')

@section('header')
<title>{{Lang::get('messages.name')}}</title> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

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
    $('#model-table').DataTable({
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
                <h3>{{Lang::get('messages.menu.admin.model.list')}}</h3>
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
                @if(isset($echou) && ($echou ==true) && isset($msg))
                <div class="alert alert-danger ">
                    <strong>{{Lang::get("validation.error")}}</strong> {{$msg}}
                </div>
                <div class="clearfix"></div>
                @endif
                <div class="x_panel">
                   
                    <div class="x_content">

                        <!--p>{{Lang::get('messages.menu.admin.car.msg')}}</p-->
                        <a href="{{url('/admin/model/add')}}" class="pull-right">
                            <button type="button" class="btn btn-success btn-secondary "><i class="fa fa-plus-circle"></i> {{Lang::get('buttons.add')}}</button>
                        </a>
                        <div class="x_content table-responsive-md" style="display: block;">
                            
                          
                            <table id="model-table" class="table table-striped table-bordered " style="width:100% ;">
                                <thead>
                                    <tr>
                                        <th>{{Lang::get('messages.menu.admin.brand.name')}}</th>
                                        <th>{{Lang::get('messages.menu.admin.car.brand')}}</th>
                                        <th>{{Lang::get('messages.menu.admin.car.nbr')}}</th>
                                         <th>{{Lang::get('messages.menu.admin.model.date')}}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                     @foreach ($list as $model) 
                                      
                                     
                                  <?php
   $origDate = $model->created_at;
 
$created_date = date("m-d-Y", strtotime($origDate));
 ?>
                                     <tr>
                                        <td>{{$model->name}}</td>
                                        <td>{{$model->brand}}</td>
                                         <td>@foreach ($list_car as $car)
                                            @if($car->idmodel==$model->id)<span>{{$car->nbre_car}}</span> @endif
                                            @endforeach </td>
                                      
                                        <td>{{$created_date}}</td>
                                       
                                        <td style="width: 15%;">
                                            <!--a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i>  </a-->
                                             <a href="{{url('/admin/model/'.$model->id.'/edit')}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>  </a>
                                            {{ Form::open(array('url' => '/admin/model/delete',"class"=>"form-horizontal form-label-left","enctype"=>"multipart/form-data")) }}
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </button>
                                              <input type="hidden" name="id"  value="{{$model->id}}">  
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