<?php

namespace App\Http\Controllers;

/**
 *
 * @author ahlemtouir
 */
use Illuminate\Http\Request;
use App\Modele;
use App\Brand;
use Response;
use Redirect;
use Lang;
use Hashids;

class ModeleController extends Controller {

    public function getListModelByBrand(Request $request) {
        $data = $request->all();
        return Response::json(Modele::getListModelByBrand($data));
    }

    public function ListModeleAdminPage() {
        $list = array();
        $list_car = array();
        $echou = false;
        $msg = null;
        try {
            $response = Modele::allModele();
            $response_car = Modele::getNbrModellByCar();
            if (isset($response["status"]) && ($response["status"] == 200)) {


                $list = isset($response["data"]) ? $response["data"] : array();
            } else {
                $echou = true;
                $msg = Lang::get("validation.brand_error");
            }
            if (isset($response_car["status"]) && ($response_car["status"] == 200)) {
                $list_car = isset($response_car["data"]) ? $response_car["data"] : array();
            } else {
                $echou = true;
                $msg = Lang::get("validation.brand_error");
            }

            return view('admin.model.index', ["list" => $list, "list_car" => $list_car, "echou" => $echou, "msg" => $msg]);
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function addModeleAdminPage() {

        $list = array();
        $echou = false;
        $msg = null;
        $response = Brand::listBrand();
        if (isset($response["status"]) && ($response["status"] == 200)) {
            $list = isset($response["data"]) ? $response["data"] : array();
        } else {
            $echou = true;
            $msg = Lang::get("validation.brand_error");
        }

        return view('admin.model.add', ["list" => $list, "echou" => $echou, "msg" => $msg]);
    }

    public function addModele(Request $request) {
        try {

            $data = $request->all();
            $response = Modele::addModele($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/model")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }
   
    public function editModelAdminPage($id) {

        $echou = false;
        $msg = null;
        $list = array();

        try {
            $response = Modele::findModelById($id);
            $response_brand = Brand::listBrand();
            if (isset($response["status"]) && ($response["status"] == 200)) {
                $model = isset($response["data"]) ? $response["data"] : array();
            } else {
                $echou = true;
                $msg = Lang::get("validation.brand_error");
            }
            if (isset($response_brand["status"]) && ($response_brand["status"] == 200)) {
                $list = isset($response_brand["data"]) ? $response_brand["data"] : array();
                $list = json_decode(json_encode($list), TRUE);
            } else {
                $echou = true;
                $msg = isset($response_brand["error"]) ? Lang::get("validation.brand_error") . " : " . $response_brand["error"] : Lang::get("validation.brand_error");
            }
          /*   $list = array_merge(array("0" => Lang::get("messages.select")), $list); */

            return view('admin.model.edit', ["model" => $model, "list" => $list, "echou" => $echou, "msg" => $msg]);
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function editModelAdmin(Request $request) {

        try {

            $data = $request->all();
            $response = Modele::editModele($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/model")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes_edit")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function deleteModelAdmin(Request $request) {

        try {

            $data = $request->all();
            $response = Modele::deleteModele($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/model")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes_edit")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    
}