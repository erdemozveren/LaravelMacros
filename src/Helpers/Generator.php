<?php
namespace erdemozveren\LaravelMacros\Helpers;

use Illuminate\Support\Facades\DB;

class Generator {
  public $table;

  function __construct($table) {
    $this->table=$table;
  }

  public function inputRules() {
    $tb = DB::select('DESCRIBE '.$this->table);
    $inputs="";
    $br="\n";
    foreach ($tb as $v) {
    if($v->Field!='id')
    $inputs.="      \"".strtolower($v->Field)."\",$br";
    }

    return rtrim($inputs);
  }

  public function validationRules() {
      $tb = DB::select('DESCRIBE '.$this->table);
      $rules=[];
      $br="\n";
      foreach ($tb as $v) {
          $r="";
          if(strpos($v->Field,"_at")) continue;
          if($v->Null=="NO"&&$v->Extra!="auto_increment") $r.="required|";
          if($v->Null=="YES") $r.="nullable|";
          if ($v->Type=="int(10) unsigned") {
              if($v->Extra!="auto_increment"){
              $r.="integer|min:0|";
              }
          }
          if ($v->Type=='int(10)') {
              $r.="integer|";
          }
          if (substr($v->Type,0,7)=='decimal'||substr($v->Type,0,5)=='float') {
              $r.="numeric|";
          }

          if ($v->Type=='tinyint(1)') {
              $r.="boolean|";
          }
          if ($v->Type=='text') {
              $r.="max:65535|";
          }

          if (substr($v->Type,0,4)=='enum') {
              preg_match_all('/(\'(.*?)(\'))/',$v->Type,$vals);
              $vals=str_replace('\'','',(implode(',',$vals[0])));
              $r.="in:".$vals."|";
          }

          if (substr($v->Type,0,7)=='varchar') {
              if($v->Field=="username"||$v->Field=="slug") {
                  $r.="alpha_dash|";
              }else if($v->Field=="email") {
              $r.="email|";
              }else {
                  $r.="string|";
              }
              preg_match('/\d+/',$v->Type,$len);
              $r.="max:".$len[0]."|";
          }
          if($r!="")
          $rules[$v->Field]=trim($r,"|");
      }
      $s='protected $rules = ['.$br;
      foreach ($rules as $key => $value) {
        $s.="        \"$key\" => \"$value\",$br";
      }
      $s.="   ];$br $br";
      /*$s.='   protected $fillable = ['.$br;
      foreach ($rules as $key => $value) {
        $s.="        \"$key\",$br";
      }
      $s.="   ];$br $br";*/


      return ["rules"=>$rules,"string"=>$s];
  }

  public function getFormFields() {
    $tb = DB::select('DESCRIBE '.$this->table);
    $data=[];
    $br="\n";
    foreach ($tb as $v) {
        if(strpos($v->Field,"_at")||$v->Field=="remember_token"||$v->Extra=="auto_increment") continue;
        $columnData=[];
        if($v->Null=="NO") $columnData["required"]=true;
        
        if($v->Null=="YES") $columnData["required"]=false;
        if(substr($v->Type,0,3)=="int") {
            $columnData["type"]="int";
        }
        if(stripos($v->Type,"unsigned")) {
            $columnData["unsigned"]=true;
        }else {
            $columnData["unsigned"]=false;
        }
        if (substr($v->Type,0,7)=='decimal'||substr($v->Type,0,5)=='float') {
            $columnData["type"]="numeric";
        }
        if ($v->Type=='tinyint(1)') {
            $columnData["type"]="boolean";
        }
        if (stripos($v->Type=='text',"text")) {
            $columnData["type"]="text";
        }

        if (substr($v->Type,0,4)=='enum') {
            preg_match_all('/(\'(.*?)(\'))/',$v->Type,$vals);
            $vals=str_replace('\'','',(implode(',',$vals[0])));
            $columnData["type"]="enum";
            $columnData["in_vals"]=$vals;
        }

        if (substr($v->Type,0,7)=='varchar') {
            if($v->Field=="password") {
                $columnData["type"]="password";
            }else {
                $columnData["type"]="varchar";
            }           
            preg_match('/\d+/',$v->Type,$len);
            $columnData["max"]=$len[0];
        }
        $data[$v->Field]=$columnData;
    }
      return $data;
  }
}