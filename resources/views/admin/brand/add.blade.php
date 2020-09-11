@extends('layouts.admin')
@section('content')

@section('header')
<title>{{Lang::get('messages.name')}}</title> 

@endsection
@section('scriptFile')

<script type="text/javascript" src="{{asset('public/js/vendor/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
@if(App::isLocale('fr'))
<script type="text/javascript" src="{{asset('public/js/vendor/bootstrapvalidator/js/fr_FR.js')}}"></script>
@endif

<script>


$(document).ready(function () {

    
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
                        <h2>{{Lang::get('messages.menu.admin.brand.add')}}</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                       
                       
                        {{ Form::open(array('url' => '/admin/brand/add',"class"=>"form-horizontal form-label-left","id"=>"addForm","enctype"=>"multipart/form-data")) }}

                        <div class="col-md-12 clearfix">

                            <div class="form-group ">
                                <label >{{Lang::get('messages.menu.admin.brand.name')}}</label>
                                <input type="text" name="name" placeholder="{{Lang::get('messages.menu.admin.brand.name')}}" data-bv-notempty="true" class="form-control ">                            
                            </div>
                        </div>
                        <div class="clearfix col-md-12">
                            <div class="ln_solid"></div>
                            <div class="col-md-6 col-sm-6 ">
                                <a class="btn cancel" href="{{url('/admin/brand')}}">
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