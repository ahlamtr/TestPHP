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
    
   
   
});

</script>
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{Lang::get('messages.menu.admin.model.add')}}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        @if(isset($echou) && ($echou ==true) && isset($msg))
                        <div class="alert alert-danger ">
                            <strong>{{Lang::get("validation.error")}}</strong> {{$msg}}
                        </div>
                        <div class="clearfix"></div>
                        @endif
                       
                        {{ Form::open(array('url' => '/admin/model/add',"class"=>"form-horizontal form-label-left","id"=>"addForm")) }}
                        <div class="col-md-6 ">

                            <div class="form-group ">
                                <label >{{Lang::get('messages.menu.admin.car.brand')}}</label>
                                {{ Form::select('idbrand', $list,'',array('class' => 'form-control idbrand','data-bv-notempty'=>'true',"data-bv-greaterthan-value"=>"1",'data-bv-feedbackicons'=>'false')) }}
                            </div>
                        </div>
                        
                        <div class="col-md-6 ">

                            <div class="form-group ">
                                <label >{{Lang::get('messages.menu.admin.brand.name')}}</label>
                                <input type="text" placeholder="{{Lang::get('messages.menu.admin.brand.name')}}" name="name"  data-bv-notempty="true" class="form-control ">                           
                            </div>
                        </div> 

                        <div class="clearfix col-md-12">
                            <div class="ln_solid"></div>
                            <div class="col-md-6 col-sm-6 ">
                                <a class="btn cancel" href="{{url('/admin/model')}}">
                                    <i class="fa fa-times-circle"></i> {{Lang::get('buttons.cancel')}}
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-6 ">

                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check-circle"></i> {{Lang::get('buttons.valid')}}</button>
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

@endsection