<?php

namespace erdemozveren\laravelmacros\Traits;
use erdemozveren\laravelmacros\FormBuilder;

trait FormBuilderTrait {
    public function formFields() {
        return [];
    }
    public function generateForm(array $options=[]) {
        return FormBuilder::fromModel($this,$options);
    }
    public function formValidationRules() {
        return false;
    }
}