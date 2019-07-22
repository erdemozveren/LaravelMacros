<?php

// Form macros for Bootstrap (mostly Admin LTE) 
Form::macro('cFg',function($name,$content) {
    $errors=optional(session('errors'))->get($name);
    return '<div class="form-group'.($errors!=null ? ' has-error':'').'">'.
    $content.
    ($errors!=null ? '<span class="help-block">'.implode("<br>",$errors).'</span>':'')
    .'</div>';
});
Form::macro('cText',function($name,$label,$placeholder=null,$options=[]) {
    return Form::cFg($name,Form::label($name, $label,config('laravelmacros.form.label')).
    Form::text($name,null,array_merge(['placeholder'=>$placeholder],config('laravelmacros.form.options'),$options)));
});

Form::macro('cColor',function($name,$label,$options=[]) {
    return Form::cFg($name,Form::label($name, $label,config('laravelmacros.form.label')).'&nbsp;&nbsp;'.$this->input('color', $name, null, $options));
});

Form::macro('cTextarea',function($name,$label,$placeholder=null,$options=[]) {
    return Form::cFg($name,Form::label($name, $label,config('laravelmacros.form.label')).
    Form::textarea($name,null,array_merge(['placeholder'=>$placeholder],config('laravelmacros.form.options'),$options)));
});

Form::macro('cNumber',function($name,$label,$options=[]) {
    return Form::cFg($name,Form::label($name, $label,config('laravelmacros.form.label')).
    Form::number($name,null,array_merge(config('laravelmacros.form.options'),$options)));
});

Form::macro('cEmail',function($name,$label,$placeholder=null,$options=[]) {
    return Form::cFg($name,Form::label($name, $label,config('laravelmacros.form.label')).
    Form::email($name,null,array_merge(['placeholder'=>$placeholder],config('laravelmacros.form.options'),$options)));
});

Form::macro('cPassword',function($name,$label,$placeholder="*******",$options=[]) {
    return Form::cFg($name,Form::label($name, $label,config('laravelmacros.form.label')).
    Form::password($name,array_merge(['placeholder'=>$placeholder],config('laravelmacros.form.options'),$options)));
});

Form::macro('cFile',function($name,$label,$options=[]) {
    return Form::cFg($name,Form::label($name, $label,config('laravelmacros.form.label')).
    Form::file($name,array_merge(config('laravelmacros.form.options'),$options)));
});

Form::macro('cCheckbox',function($name,$label,$value=1,$checked=null) {
    return "<div class='checkbox'><label>".Form::checkbox($name,$value,$checked)." $label</label></div>";
});

Form::macro('cRadio',function($name,$label,$value,$checked=null) {
    return Form::label($name, $label,config('laravelmacros.form.label')).
    Form::radio($name,$value,$checked);
});

Form::macro('cSubmit',function($label="Submit",$class="") {
    return 
    Form::submit($label,['class'=>'btn '.$class]);
});
Form::macro('cSelect',function($name,$label,$data,$key=null,$value=null,$options=[]) {    
    
    if($key!=null){
    $newData=[];
    foreach($data as $dKey=>$item) {
        if(is_string($dKey)) {
            foreach ($item as $subItem) {            
                $newData[$dKey][$subItem[$key]]=$subItem[$value];
            }
        }else {            
            $newData[$item[$key]]=$item[$value];
        }
    }
    }
    return Form::cFg($name,Form::label($name, $label,config('laravelmacros.form.label')).    
    Form::select($name, $key!=null ? $newData:$data, null, array_merge(config('laravelmacros.form.options'),$options)));
});