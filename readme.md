# LaravelMacros

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require erdemozveren/laravelmacros
```

## Usage
###Form Builder
in your model file
```use erdemozveren\LaravelMacros\Traits\FormBuilderTrait;```
in model class 
```
use FormBuilderTrait;
// Form fields
    public function formFields() {
        return [
            "*"=>[ // wildcard will be applied to all elements 
                "options"=>
                ["style"=>"color:red!important"]
            ],
            "parent_id"=>[ // "parent_id" is the name attribute
                "type"=>"select", // input type
                "label"=>"Parent", // label text
                "data"=>User::get(), // [ONLY FOR SELECT COLUMN]
                "data_key"=>"id", // value key
                "data_value"=>"full_name", // text key
                "options"=>[ // optional
                    "required"=>false // optional make input optional
                    // ... and other "collective" options and dom parameters can be used in here
                ]
            ],
            "full_name"=>[
                "type"=>"text",
                "label"=>"İsim",
            ],
            "email"=>[
                "type"=>"text",
                "label"=>"E-posta",
            ],
            "password"=>[
                "type"=>"password",
                "label"=>"Şifre",
            ],
        ];
    }

```
## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/erdemozveren/laravelmacros.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/erdemozveren/laravelmacros.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/erdemozveren/laravelmacros/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/erdemozveren/laravelmacros
[link-downloads]: https://packagist.org/packages/erdemozveren/laravelmacros
[link-travis]: https://travis-ci.org/erdemozveren/laravelmacros
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/erdemozveren
[link-contributors]: ../../contributors
