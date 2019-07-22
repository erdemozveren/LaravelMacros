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
        $data=[];
        foreach ($rules as $key => $val) {
            $colData=[];
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
                break;
                case "text":
                    $colData["type"]="textarea";
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
           echo "\n\"".$key.'"=>';
           if(is_array($val)) {
               echo "[";
               $this->printAll($val);
               echo "],\n";
           }else {
               echo "\t\"".$val."\",";
           }
       }
    }
    
}
