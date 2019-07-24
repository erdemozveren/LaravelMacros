<?php

namespace erdemozveren\laravelmacros\Commands;

use Illuminate\Console\Command;
use erdemozveren\laravelmacros\Helpers\Generator;
class FormFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravelmacros:formfields {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get simple formFileds function';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    
        $table=$this->argument("table");
        $g=new Generator($table);
        $this->info("Generating formfield function for <bg=blue>".$table."</>\n");
        $rules=$g->getFormFields();
        $field_names=collect($rules)->keys()->toArray();
        
        $this->line("Field Names : <bg=blue>".implode("</>,<bg=blue>",$field_names)."</>");
        $exclude=explode(",",$this->anticipate("(optional) Column names to exclude (comma seperated)",$field_names));
        // exclude given fields
        if(!empty($exclude)) {
            foreach ($exclude as $value) {
                unset($rules[$value]);
            }
        }
        $relationNames=[];
        $askRelation=1;
        if($this->confirm("Do you want to add a relation input (selectbox)",false)) { //default is false
        $this->comment("\t\tRELATION MANAGER");
        while($askRelation) {
            $relName=$this->anticipate("Column name",$field_names);
            if(empty($relName))
            $askRelation=0;
            $relData=$this->anticipate("Data Source (e.g. App\\User::pluck('first_name','id')",$field_names);
            $rules[$relName]["data"]=">".$relData;
            $rules[$relName]["type"]="select"; // make it select
            if(!$this->confirm("Do you want to add another one ?",false)) { //default is false
                $askRelation=0;
            }
        }
        }
        $data=[];
        foreach ($rules as $key => $val) {
            $colData=[];
            $colData["label"]=ucfirst($key);
            switch($val["type"]) {
                case "varchar":
                    $colData["type"]="text";
                break;
                case "enum":
                    $colData["type"]="select";
                    foreach(explode(",",$val["in_vals"]) as $v) {
                        $colData["data"][$v]=ucfirst($v);
                    }
                break;
                case "boolean":
                    $colData["type"]="checkbox";
                    $colData["value"]="1";
                    $colData["checked"]=null;
                break;
                case "text":
                    $colData["type"]="textarea";
                break;
                case "int":
                    $colData["type"]="number";
                break;
                case "select":
                    $colData["data"]=$val["data"];
                default:
                $colData["type"]=$val["type"];
                break;
            }
            if($val["required"]) {
                $colData["options"]["required"]="required";
            }else {
                $colData["options"]["required"]=">false";
            }
            $rules[$key]=$colData;
        }
        $this->info("start copying from here");
        $this->line("public function formFields() {\n\treturn [");
        $this->printAll($rules); 
        $this->line("\n\t];\n}");
        
    }

    function printAll($a) {
       foreach($a as $key=>$val) {
           echo "\n\t\"".$key.'"=>';
           if(is_array($val)) {
               echo "[";
               $this->printAll($val);
               echo "\n\t],\n";
           }else {
               if(substr($val,0,1)==">"){ // act as pure php 
                    echo substr($val,1).",";
               }else {
                    echo "\"".$val."\",";
               }
           }
       }
    }
    
}
