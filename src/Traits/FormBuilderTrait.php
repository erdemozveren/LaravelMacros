<?php

namespace erdemozveren\LaravelMacros\Traits;
use erdemozveren\LaravelMacros\Form;
trait FormBuilderTrait {
    public function formFields() {
        return [];
    }
    public function generateForm(array $options=[]) {
        return Form::buildFromModel($this,$options);
    }
    public function formValidationRules() {
        return false;
    }
}