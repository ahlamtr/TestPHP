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

<script>

$(document).ready(function () {
    
});

@endsection

@section('content')
<div class="right_col" role="main">

    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{Lang::get('messages.menu.admin.car.view')}}</h3>
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 ">
               
                @if(isset($echou) && ($echou ==true) && isset($msg))
                <div class="alert alert-danger ">
                    <strong>{{Lang::get("validation.error")}}</strong> {{$msg}}
                </div>
                <div class="clearfix"></div>
                @endif
            
                <div class="x_panel">
                    <div class="x_title">
                        <h2> <small>{{Lang::get("messages.menu.car.specifications.title")}}</small></h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <?php
                        $name = "";
                        if (isset($car->brand)) {
                            $name = $car->brand;
                        }
                        if (isset($car->modele)) {
                            $name .= " " . $car->modele;
                        }


                        $id = Hashids::encode($car->id);
                        ?>
                        <div class="col-md-3 col-sm-3  profile_left">
                            
                            <h3>{{$name}}</h3>

                            <a href="{{url('/admin/car/edit?cid='.$id)}}" class="btn btn-success"><i class="fa fa-edit m-right-xs" style="color: #fff;"></i><span style="color: #fff;">{{Lang::get("messages.menu.admin.car.edit")}}</span></a>
                            <br />



                        </div>
                        <div class="col-md-9 col-sm-9 ">

                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

                                    <li role="presentation" class="active"><a href="#tab_content1" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="true">{{Lang::get("messages.admin.car.specifications")}}</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">{{Lang::get("messages.admin.car.description")}}</a>
                                    </li>

                                </ul>
                                <div id="myTabContent" class="tab-content">
                                   
                                    <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="profile-tab">

                                        <table class="data table table-striped no-margin">
                                           
                                            <tbody>
                                                <tr>
                                                    <td>{{Lang::get('messages.menu.admin.car.brand')}}</td>

                                                    <td class="vertical-align-mid">
                                                        {{$car->brand}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{Lang::get('messages.menu.admin.car.model')}}</td>

                                                    <td class="vertical-align-mid">
                                                        {{$car->modele}}
                                                    </td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>

                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab2">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection