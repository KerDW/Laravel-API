<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = null;

        if($request->q){

            $countries = Country::where('name', 'like', '%'.$request->q.'%')->get();

        } else {

            $countries = Country::all();

        }

        return $countries;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return $country;
    }

    public static function importCSV(Request $request = null, $commandLine = null, $source = null)
    {
        $filename = "public/countries.csv";
        if ($request && $request->filename) {
            $filename = $request->filename;
        }
        $file = $source;

        if (!$source) {
            $file = Storage::disk("local")->get($filename);
        }
        /*
        0Code
        1Country
        2Nationality

         */
        $countries = \App\Country::all();

        DB::beginTransaction();
        foreach (explode(PHP_EOL, $file) as $line) {
            $data = explode(';', $line);

            $name = $data[0];

            $country = \App\Country::where("name", "=", $name)->get()->first();

            if (!$country) {
                $country = new \App\Country();
            }
            try {
                $country->name = isset($name) ? $name : null;

                if(!$name){
                    continue;
                }

                $country->save();

                $countries[] = $country;

            } catch (\Exception $ex) {
                $rejected[] = ["exception" => $ex->getMessage()];
                if ($commandLine) {
                    $commandLine->error("Exception: " . $ex->getMessage());
                }
            } catch (QueryException $ex) {
                $rejected[] = ["exception" => "SQL: " . $ex];
            }
        }

        DB::commit();
        return true;
    }


}
