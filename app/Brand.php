<?php

namespace App;

/**
 * Description of Brand
 *
 * @author ahlemtouir
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Jsonable;
use App\ExceptionList;
use App\Car;
use App\Modele;

class Brand extends Model {

    protected $table = 'brands';
    protected $fillable = array("*");

    public static function listBrand() {
        $response = [];
        try {
            $list = Brand::pluck('name', 'id');
            $response = [
                "status" => 200,
                "data" => $list
            ];
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

    public static function allBrand() {
        $response = [];
        try {
            $list = Brand::all();
            $response = [
                "status" => 200,
                "data" => $list
            ];
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

    public static function getNbrBrandlByCar() {
        $response = [];
        try {
            $list = Car::select(array(DB::raw("COUNT(*) as nbre_car,idbrand")))->groupBy("idbrand")->having("nbre_car", ">", 0)->get();
            $response = [
                "status" => 200,
                "data" => $list
            ];
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

    public static function getNbrBrandlByModel() {
        $response = [];
        try {
            $list = Modele::select(array(DB::raw("COUNT(*) as nbre_model,idbrand")))->groupBy("idbrand")->having("nbre_model", ">", 0)->get();
            $response = [
                "status" => 200,
                "data" => $list
            ];
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

    public static function deleteBrand($data) {
        $response = [];
        try {
            $brand = Brand::find($data["id"]);
            if (isset($brand)) {
                $brand->delete();
                $list = Modele::where("idbrand", "=", $data["id"])->delete();
                $response = [
                    "status" => 200,
                    "data" => "TRUE"
                ];
            } else {
                $response = [
                    "status" => 400,
                    "error" => "NOTFOUND"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

    public static function findBrandById($id) {
        $response = [];
        try {
            $brand = Brand::find($id);
            if (isset($brand)) {
                $response = [
                    "status" => 200,
                    "data" => $brand
                ];
            } else {
                $response = [
                    "status" => 400,
                    "error" => "NOTFOUND"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

    public static function editBrand($data) {
        $response = [];
        try {
            $brand = Brand::find($data["id"]);
            if (isset($brand)) {
                $brand->name = $data["name"];
               
                if ($brand->save()) {

                    $response = [
                        "status" => 200,
                        "data" => $brand
                    ];
                } else {
                    $response = [
                        "status" => 400,
                        "error" => "FAILED"
                    ];
                }
            } else {
                $response = [
                    "status" => 400,
                    "error" => "NOTFOUND"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

    public static function addBrand($data) {
        $response = [];
        try {
            $brand = new Brand();

            $brand->name = $data["name"];
            
            if ($brand->save()) {

                $response = [
                    "status" => 200,
                    "data" => $brand
                ];
            } else {
                $response = [
                    "status" => 400,
                    "error" => "FAILED"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

}
