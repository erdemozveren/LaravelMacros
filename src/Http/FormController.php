<?php

namespace erdemozveren\laravelmacros\Http;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use erdemozveren\laravelmacros\Helpers\Generator;
use Illuminate\Support\Facades\DB;
use Route;
class FormController extends BaseController
{
    public function showForm()
    {
        if(!Route::has('laravelmacros.dev.generateform')) throw new \Exception("You must define a 'laravelmacros.dev.generateform' route!");
        $tables=null;
        try {
            $tables=collect(DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='".env('DB_DATABASE')."'"))->pluck("TABLE_NAME","TABLE_NAME");
        }catch(\Exception $err) {

        }
        return view("laravelmacros::formfields_form",compact("tables"));
    }

    public function generateForm(Request $request)
    {
        $relations = $request->relations;
        $table = $request->table;
        if(!$table) return "Table name can not be empty!";
        $generator = new Generator($table);
        $r=[];
        $r["rules"]=str_replace("\n","<br>",$generator->validationRules()["string"]);
        $fieldsArray=$generator->getFormFieldMethod($relations);
        $formfields="";
        $this->printAll($formfields,$fieldsArray);
        //  $r["preview"]=$generator->getPreviewForm($fieldsArray);
        $r["function"]="public function formFields() {<br>return [".$formfields."<br>];<br>}";
        return response()->json($r);
    }
    public function printAll(&$string,$a) {
        foreach($a as $key=>$val) {
            $string.= "<br>\"".$key.'"=>';
            if(is_array($val)) {
                $string.= "[";
                $this->printAll($string,$val);
                $string.= "<br>],\n";
            }else {
                if(substr($val,0,1)==">"){ // act as pure php 
                     $string.= substr($val,1).",";
                }else {
                     $string.= "\"".$val."\",";
                }
            }
        }
     }
}