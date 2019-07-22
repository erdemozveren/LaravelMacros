<?php

namespace erdemozveren\LaravelMacros\Commands;

use Illuminate\Console\Command;
use erdemozveren\LaravelMacros\Helpers\Generator;
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
        $this->info("Generating formfield function for <bg=blue>".$table."</>");
        $rules=$g->getFormFields();
        $exclude=explode(",",$this->askWithCompletion("(optional) Column names to exclude (comma seperated)",array_keys($rules)));
        // exclude given fields
        if(!empty($exclude)) {
            foreach ($exclude as $value) {
                $this->error("Excluded : ".$value);
                unset($rules[$value]);
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
                default:
                $colData["type"]=$val["type"];
                break;
            }
            if($val["required"]) {
                $colData["options"]["required"]="required";
            }else {
                $colData["options"]["required"]="false";
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
               if(preg_match("(false|null)",$val) == 1) {
                   echo $val.",";
               }else {
                echo "\"".$val."\",";
               }
           }
       }
    }
    
}
