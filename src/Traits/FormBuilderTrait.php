<?php

namespace erdemozveren\LaravelMacros\Traits;
trait FormBuilderTrait {
    public function formFields() {
        return [];
    }
    public function generateForm(array $options=[]) {
        return \erdemozveren\LaravelMacros\Form::buildFromModel($this,$options);
    }
}