<?php

/**
 * Description of Modele
 * 
 * @author ahlemtouir
 */

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Car;

class Modele extends Model {

    protected $table = 'models';
    protected $fillable = array("*");

    public static function getListModelByBrand($data) {
        $response = [];
        
        try {
            if (isset($data["select"]) && ($data["select"] == TRUE)) {
                $list = Modele::where("idbrand", "=", $data["idbrand"])->pluck('name', 'id');
            } else {
                $list = Modele::where("idbrand", "=", $data["idbrand"])->get(array("id", "name"));
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

    public static function allModele() {
        $response = [];
        try {

            $list = Modele::join("brands", "brands.id", "=", "models.idbrand")
                            ->orderBy("created_at", "DESC")->get(array("models.*", "brands.name as brand"));

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

    public static function getNbrModellByCar() {
        $response = [];
        try {
            $list = Car::select(array(DB::raw("COUNT(*) as nbre_car,idmodel")))->groupBy("idmodel")->having("nbre_car", ">", 0)->get();
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

    public static function addModele($data) {
        $response = [];
        try {
            $model = new Modele();
            $model->idbrand = $data["idbrand"];
            $model->name = $data["name"];
            if ($model->save()) {

                $response = [
                    "status" => 200,
                    "data" => $model
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
 
    public static function findModelById($id) {
        $response = [];
        try {
            $modele = Modele::find($id);

            if (isset($modele)) {
                $response = [
                    "status" => 200,
                    "data" => $modele
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

    public static function editModele($data) {
        $response = [];
        try {
            $modele = Modele::find($data["id"]);
            if (isset($modele)) {
                $modele->name = $data["name"];
                $modele->idbrand = $data["idbrand"];
                if ($modele->save()) {

                    $response = [
                        "status" => 200,
                        "data" => $modele
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

    public static function deleteModele($data) {
        $response = [];
        try {
            $modele = Modele::find($data["id"]);
            if (isset($modele)) {
                $modele->delete();
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
}
