<?php

namespace App\Http\Controllers;

/**
 *
 * @author ahlemtouir
 */
use App\Car;
use Illuminate\Http\Request;
use App\Brand;
use Redirect;
use Lang;
use Session;
use Hashids;
use Response;

class BrandController extends Controller {

    public function ListBrandAdminPage() {
        $list = array();
        $list_car = array();
        $list_model = array();
        $echou = false;
        $msg = null;
        try {
            $response = Brand::allBrand();
            $response_Car = Brand::getNbrBrandlByCar();
            $response_Model = Brand::getNbrBrandlByModel();
            if (isset($response["status"]) && ($response["status"] == 200)) {


                $list = isset($response["data"]) ? $response["data"] : array();
            } else {
                $echou = true;
                $msg = Lang::get("validation.brand_error");
            }
            if (isset($response_Car["status"]) && ($response_Car["status"] == 200)) {


                $list_car = isset($response_Car["data"]) ? $response_Car["data"] : array();
            } else {
                $echou = true;
                $msg = Lang::get("validation.brand_error");
            }
            if (isset($response_Model["status"]) && ($response_Model["status"] == 200)) {


                $list_model = isset($response_Model["data"]) ? $response_Model["data"] : array();
            } else {
                $echou = true;
                $msg = Lang::get("validation.brand_error");
            }

            return view('admin.brand.index', ["list" => $list, "list_car" => $list_car, "list_model" => $list_model, "echou" => $echou, "msg" => $msg]);
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function deleteBrandAdmin(Request $request) {

        try {

            $data = $request->all();
            $response = Brand::deleteBrand($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/brand")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes_edit")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function editBrandAdminPage($id) {

        $echou = false;
        $msg = null;
        try {
            $response = Brand::findBrandById($id);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                $brand = isset($response["data"]) ? $response["data"] : array();
            } else {
                $echou = true;
                $msg = Lang::get("validation.brand_error");
            }
            return view('admin.brand.edit', ["brand" => $brand, "echou" => $echou, "msg" => $msg]);
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function editBrandAdmin(Request $request) {

        try {

            $data = $request->all();
            $response = Brand::editBrand($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/brand")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes_edit")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }

    public function addBrandAdminPage() {
       
         return view('admin.brand.add');
    }

     public function addBrand(Request $request) {
        try {

            $data = $request->all();
            $response = Brand::addBrand($data);
            if (isset($response["status"]) && ($response["status"] == 200)) {
                return Redirect::to("/admin/brand")->with(array("success" => true, "success_text" => Lang::get("validation.add_succes")));
            } else {
                return Redirect::back()->with(array("error" => true, "error_text" => isset($response["error"]) ? Lang::get("validation.add_error") . " : " . $response["error"] : Lang::get("validation.add_error")));
            }
        } catch (Exception $ex) {
            return Redirect::back()->with(array("error" => true, "error_text" => Lang::get("validation.add_error") . " : " . $ex->getMessage()));
        }
    }
}