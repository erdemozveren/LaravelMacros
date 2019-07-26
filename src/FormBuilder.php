<?php

namespace erdemozveren\laravelmacros;

use Illuminate\Database\Eloquent\Model;
use ErrorException;
use Collective\Html\FormFacade as cForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormBuilder
{
    // Build form from given model with some options
    public static function fromModel($model,array $options=[]) {
        if(!method_exists($model,"formFields")) throw new ErrorException("Model do not have formField method.Check Docs about formFields method.");
        $options=array_replace_recursive($model->formFields(),$options);
        $form="";
        $extraOptions=[];
        // wildCard will be applied all inputs
        $wildCard=isset($options["*"]) ? $options["*"]:[];
        // exclude given elements
        if(isset($options["_exclude"])) {
            foreach ($options["_exclude"] as $value) {
                unset($options[$value]);
            }
        }
        foreach ($options as $key => $val) {
            if($key=="*"||$key=="_exclude") continue;
            if(!empty($wildCard)) {
                $val=array_replace_recursive($val,$wildCard);
            }
            $inputOptions=isset($val["options"]) ? $val["options"] : [];
            
            $placeholder=isset($val["placeholder"]) ? $val["placeholder"] : null;
            switch ($val["type"]) {
                case 'select':
                   $form.=cForm::{"c".ucfirst($val["type"])}($key,$val["label"],$val["data"],$inputOptions);
                break;
                case 'password':
                   $form.=cForm::{"c".ucfirst($val["type"])}($key,$val["label"],$placeholder,$inputOptions);
                break;
                case 'checkbox':
                case 'radio':
                   $form.=cForm::{"c".ucfirst($val["type"])}($key,$val["label"],$val["value"],null); // removed $val["checked"] for unwanted results
                break;
                case 'color':
                case 'number':
                case 'file';
                   $form.=cForm::{"c".ucfirst($val["type"])}($key,$val["label"],$inputOptions);
                break;
                // other elements share the same parameters.
                default:
                $form.=cForm::{"c".ucfirst($val["type"])}($key,$val["label"],$placeholder,$inputOptions);
                break;
            }
        }
        return $form;
    }
    // disabled for now
    public static function handleForm(Model $model,Request $request,array $options=[]) {
        if(!method_exists($model,"formFields")) throw new ErrorException("Model do not have formField method.Check Docs about formFields method.");
        if(!method_exists($model,"formValidationRules")) throw new ErrorException("Model do not have validation rules check Docs about formValidationRules method.");
        $fields=array_replace_recursive($model->formFields(),$options);
        // unset wildcard
        unset($fields["*"]);
        // exclude given fields
        if(isset($options["_exclude"])) {
            foreach ($options["_exclude"] as $value) {
                unset($fields[$value]);
            }
        }
        $inputs = $request->only(array_keys($fields));
        $rules=$model->formValidationRules();
        if($rules!=false) {
            $validator = Validator::make($inputs,$rules);
            if($validator->fails()) {
                return ["errors"=>$validator->errors()];
            }
        }
        foreach ($inputs as $key => $value) {
            $model->{$key} = $value;
        }
        return true;
    }
}