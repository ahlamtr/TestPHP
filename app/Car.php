<?php

namespace App;

/**
 * Description of Car
 * 
 * @author ahlemtouir
 */


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Session;

class Car extends Model {

    protected $table = 'cars';
    protected $fillable = array("*");

    public static function searchAdminCar() {
        $response = [];
        try {
            $query = Car::query();
            $query->join("brands", "brands.id", "=", "cars.idbrand")
                    ->join("models", "models.id", "=", "cars.idmodel");
            if (Session::has("search_admin")) {
                if (Session::has("idbrand")) {
                    $idbrand = Session::get("idbrand");
                    if (isset($idbrand) && ($idbrand != "") && ($idbrand != "0") && ($idbrand != 0)) {
                        $query->where("cars.idbrand", "=", $idbrand);
                    }
                }
                if (Session::has("idmodel")) {
                    $idmodel = Session::get("idmodel");
                    if (isset($idmodel) && ($idmodel != "") && ($idmodel != "0") && ($idmodel != 0)) {
                        $query->where("cars.idmodel", "=", $idmodel);
                    }
                }
                $list = $query->orderBy("created_at", "DESC")->get(array("cars.*", "brands.name as brand", "models.name as modele"));
            } else {
        
                $list = $query->orderBy("created_at", "DESC")->get(array("cars.*", "brands.name as brand", "models.name as modele"));
            }
            

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

    public static function FindCar($data) {
        $response = [];
        try {
            $car = Car::where("cars.id", "=", $data["id"])
                            ->join("brands", "brands.id", "=", "cars.idbrand")
                            ->join("models", "models.id", "=", "cars.idmodel")
                            ->orderBy("created_at", "DESC")->get(array("cars.*", "brands.name as brand", "models.name as modele"))->first();
            if (isset($car)) {
                
                $response = [
                    "status" => 200,
                    "data" => $car
                ];
            } else {
                $response = [
                    "status" => 400,
                    "error" => "NotFound"
                ];
            }
            /* print_r(json_encode($response));die(); */
        } catch (Exception $e) {
            $response = [
                "status" => 400,
                "error" => $e->getMessage(),
                'line' => $e->getLine()
            ];
        }
        return $response;
    }

    public static function searchCar() {
        $response = [];
        try {
            $booked_day = [];
            $query = Car::query();
            $query->join("brands", "brands.id", "=", "cars.idbrand")
                  ->join("models", "models.id", "=", "cars.idmodel");
            
            $list = $query->orderBy("created_at", "DESC")->groupBy("cars.id")->get(array("cars.*", "brands.name as brand", "models.name as modele"));

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

    public static function editCar($data) {
        $response = [];

        try {
            $car = Car::find($data["id"]);
            if (isset($car)) {
                if (isset($data["idbrand"])) {
                    $car->idbrand = $data["idbrand"];
                }
                if (isset($data["idmodel"])) {
                    $car->idmodel = $data["idmodel"];
                }
                if (isset($data["name"])) {
                    $car->name = $data["name"];
                }
               
                if ($car->save()) {
                   
                    $response = [
                        "status" => 200,
                        "data" => $car
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

    public static function deleteCar($data) {
        $response = [];
        try {
            $car = Car::find($data["id"]);
            if (isset($car)) {
                $car->delete();
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

    public static function addCar($data) {
        $response = [];
        try {

            $car = new Car();
            $car->idbrand = $data["idbrand"];
            $car->idmodel = $data["idmodel"];
            $car->name = $data["name"];
          
            if ($car->save()) {
               
                $response = [
                    "status" => 200,
                    "data" => $car
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
