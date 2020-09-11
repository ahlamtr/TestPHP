<?php

namespace App\Http\Controllers;

/**
 *
 * @author ahlemtouir
 */
use App\Car;
use Illuminate\Http\Request;
use Hashids;
use App\Brand;
use App\Modele;
use Redirect;
use Lang;
use Session;

class CarController extends Controller {

    public function ListCarAdminPage(Request $request) {

        if ($request->has("first")) {
            session(['idbrand' => null, 'idmodel' => null, "search_admin" => null]);
            return Redirect::to("/admin/car");
        }
        $cars = array();
        $brands = array();
        $models = array();
        $echou = false;
        $msg = null;
      
        try {
            if (Session::has("idbrand")) {
                $idbrand = Session::get("idbrand");
                if (isset($idbrand) && ($idbrand != "") && ($idbrand != "0") && ($idbrand != 0)) {
                    $response_model = Modele::getListModelByBrand(array("idbrand" => $idbrand, 'select' => TRUE));
                    if (isset($response_model["status"]) && ($response_model["status"] == 200)) {
                        $models = isset($response_model["data"]) ? $response_model["data"] : array();
                        $models = json_decode(json_encode($models), TRUE);
                    } else {
                        $echou = true;
                        $msg = isset($response_model["error"]) ? Lang::get("validation.model_error") . " : " . $response_model["error"] : Lang::get("validation.model_error");
                    }
 
                }
            }
            
        
            $response_search = Car::searchAdminCar();

            if (isset($response_search["status"]) && ($response_search["status"] == 200)) {
                $cars = isset($response_search["data"]) ? $response_search["data"] : array();
                $response_brand = Brand::listBrand();
                if (isset($response_brand["status"]) && ($response_brand["status"] == 200)) {
                    $brands = isset($response_brand["data"]) ? $response_brand["data"] : array();
                    $brands = json_decode(json_encode($brands), TRUE);
                } else {
                    $echou = true;
                    $msg = isset($response_brand["error"]) ? Lang::get("validation.brand_error") . " : " . $response_brand["error"] : Lang::get("validation.brand_error");
                }
            } else {
                $echou = true;
                $msg = isset($response_search["error"]) ? Lang::get("validation.car_error") . " : " . $response_search["error"] : Lang::get("validation.car_error");
            }
        } catch (Exception $ex) {
            $echou = true;
            $msg = Lang::get("validation.car_error") . " : " . $ex->getMessage() . " Line " . $ex->getLine();
        }
        $brands = array("0" => Lang::get("messages.select")) + $brands;
        $models = array("0" => Lang::get("messages.select")) + $models;

        return view('admin.car.index', ["echou" => $echou, "msg" => $msg, "models" => $models, "list" => $brands, "list_car" => $cars]);
    }

    public function viewCarAdminPage(Request $request) {
        try {

            $data = $request->all();
            if (isset($data["cid"]) && ($data["cid"] != "")) {
                $ids = Hashids::decode($data["cid"]);
                if (isset($ids[0])) {
                    $id = $ids[0];
                    $response_view = Car::FindCar(array("id" => $id));

                    if (isset($response_view["status"]) && ($response_view["status"] == 200) && isset($response_view["data"])) {
                        $car = $response_view["data"];
                        return view('admin.car.view', ["car" => $car,"cid" => $data["cid"]]);
                    } else {
                        $msg = isset($response_view["error"]) ? Lang::get("validation.view_car_error") . " : " . $response_view["error"] : Lang::get("validation.view_car_error");
                        return Redirect::to("/admin/car")->with(array("error" => true, "error_text" => $msg));
                    }
                } else {
                    return Redirect::to("/admin/car")->with(array("error" => true, "error_text" => Lang::get("validation.view_car_error")));
                }
            } else {
                return Redirect::to("/admin/car")->with(array("error" => true, "error_text" => Lang::get("validation.view_car_error")));
            }
        } catch (Exception $ex) {
            return Redirect::to("/admin/car")->with(array("error" => true, "error_text" => Lang::get("validation.view_car_error") . " : " . $ex->getMessage()));
        }
    }

    public function editCarAdminPage(Request $request) {

        try {
           
            $data = $request->all();
            if (isset($data["cid"]) && ($data["cid"] != "")) {
                $ids = Hashids::decode($data["cid"]);
                if (isset($ids[0])) {
                    $id = $ids[0];
                    $response_view = Car::FindCar(array("id" => $id));
                    
                    if (isset($response_view["status"]) && ($response_view["status"] == 200) && isset($response_view["data"])) {
                        $car = $response_view["data"];

                        $idbrand = $car->idbrand;
                        if (isset($idbrand) && ($idbrand != "") && ($idbrand != "0") && ($idbrand != 0)) {
                            $response_model = Modele::getListModelByBrand(array("idbrand" => $idbrand, 'select' => TRUE));
                            if (isset($response_model["status"]) && ($response_model["status"] == 200)) {
                                $models = isset($response_model["data"]) ? $response_model["data"] : array();
                                $models = json_decode(json_encode($models), TRUE);
                            } else {
                                $echou = true;
                                $msg = isset($response_model["error"]) ? Lang::get("validation.model_error") . " : " . $response_model["error"] : Lang::get("validation.model_error");
                            }
                        }

                        $response_search = Car::searchCar();
                        if (isset($response_search["status"]) && ($response_search["status"] == 200)) {
                            $cars = isset($response_search["data"]) ? $response_search["data"] : array();
                            $response_brand = Brand::listBrand();
                            if (isset($response_brand["status"]) && ($response_brand["status"] == 200)) {
                                $brands = isset($response_brand["data"]) ? $response_brand["data"] : array();
                                $brands = json_decode(json_encode($brands), TRUE);
                            } else {
                                $echou = true;
                                $msg = isset($response_brand["error"]) ? Lang::get("validation.brand_error") . " : " . $response_brand["error"] : Lang::get("validation.brand_error");
                            }
                        } else {
                            $echou = true;
                            $msg = isset($response_search["error"]) ? Lang::get("validation.car_error") . " : " . $response_search["error"] : Lang::get("validation.car_error");
                        }

                        $brands = array("0" => Lang::get("messages.select")) + $brands;
                        $models = array("0" => Lang::get("messages.select")) + $models;
   
                        return view('admin.car.edit', ["car" => $car, "brands" => $brands, "models" => $models]);
                    } else {
                        $msg = isset($response_view["error"]) ? Lang::get("validation.view_car_error") . " : " . $response_view["error"] : Lang::get("validation.view_car_error");
                        return Redirect::to("/admin/car")->with(array("error" => true, "error_text" => $msg));
                    }
                } else {
                    return Redirect::to("/admin/car")->with(array("error" => true, "error_text" => Lang::get("validation.view_car_error")));
                }
            } else {
                return Redirect::to("/admin/car")->with(array("error" => true, "error_text" => Lang::get("validation.view_car_error")));
            }
        } catch (Exception $ex) {
            return Redirect::to("/admin/car")->with(array("error" => true, "error_text" => Lang::get("validation.view_car_error") . " : " . $ex->getMessage()));
        }
    }

    public function editCarAdmin(Request $request) {

        try {

            $data = $request->all();
            $response = Car::editCar($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/car")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes_edit")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function deleteCarAdmin(Request $request) {

        try {

            $data = $request->all();
            $response = Car::deleteCar($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/car")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes_edit")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function addCarAdminPage() {

        $list = array();
        $echou = false;
        $msg = null;
       
        try {
            $response = Brand::listBrand();
            if (isset($response["status"]) && ($response["status"] == 200)) {
                $list = isset($response["data"]) ? $response["data"] : array();
                $list = json_decode(json_encode($list), TRUE);
            } else {
                $echou = true;
                $msg = isset($response["error"]) ? Lang::get("validation.brand_error") . " : " . $response["error"] : Lang::get("validation.brand_error");
            }
        } catch (Exception $ex) {
            $echou = true;
            $msg = Lang::get("validation.brand_error") . " : " . $ex->getMessage() . " Line " . $ex->getLine();
        }
        $list = array("0" => Lang::get("messages.select")) + $list;
        return view('admin.car.add', ["list" => $list, "echou" => $echou, "msg" => $msg]);
    }

    public function addCar(Request $request) {
        try {

            $data = $request->all();
            $response = Car::addCar($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/car")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function SearchAdminCars(Request $request) {
        try {

            $data = $request->all();
            $idbrand = isset($data["idbrand"]) ? $data["idbrand"] : null;
            $idmodel = isset($data["idmodel"]) ? $data["idmodel"] : null;

            session(['idbrand' => $idbrand, 'idmodel' => $idmodel, "search_admin" => TRUE]);
            return Redirect::to("admin/car");
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.search_error") . " : " . $ex->getMessage()));
        }
    }


}