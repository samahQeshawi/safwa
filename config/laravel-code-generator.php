<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CodeGenerator config overrides
    |--------------------------------------------------------------------------
    |
    | It is a good idea to sperate your configuration form the code-generator's
    | own configuration. This way you won't lose any settings/preference
    | you have when upgrading to a new version of the package.
    |
    | Additionally, you will always know any the configuration difference between
    | the default config than your own.
    |
    | To override the setting that is found in the codegenerator.php file, you'll
    | need to create identical key here with a different value
    |
    | IMPORTANT: When overriding an option that is an array, the configurations
    | are merged together using php's array_merge() function. This means that
    | any option that you list here will take presence during a conflict in keys.
    |
    | EXAMPLE: The following addition to this file, will add another entry in
    | the common_definitions collection
    |
    |   'common_definitions' =>
    |   [
    |       [
    |           'match' => '*_at',
    |           'set' => [
    |               'css-class' => 'datetime-picker',
    |           ],
    |       ],
    |   ],
    |
     */
    'common_definitions' =>
      [
            [
            'match' => ['*_date', 'date_*', 'dob'],
            'set' => [
                'class'   => 'date-picker',
                'data-type' => 'date',
                'date-format' => 'MMMM Do YYYY',
            ],
        ],
        [
            'match' => ['created_at', 'updated_at', 'deleted_at'],
            'set' => [
                'class'   => 'datetime-picker',
                'data-type' => 'datetime',
                'date-format' => 'MMMM Do YYYY, h:mm:ss a',
                'is-on-form' => false,
                'is-api-visible' => false,
                'is-on-index' => false,
                'is-on-show' => true,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | The default path of where the uploaded files live.
    |--------------------------------------------------------------------------
    |
    | You can use Laravel Storage filesystem. By default, the code-generator
    | uses the default file system.
    | For more info about Laravel's file system visit
    | https://laravel.com/docs/5.5/filesystem
    |
     */
    'files_upload_path' => 'uploads',
    'organize_migrations' => true,
     /*
    |--------------------------------------------------------------------------
    | The default template to use.
    |--------------------------------------------------------------------------
    |
    | Here you change the stub templates to use when generating code.
    | You can duplicate the 'default' template folder and call it whatever
    | template name you like 'ex. skyblue'. Now, you can change the stubs to
    | have your own templates generated.
    |
    |
    | IMPORTANT: It is not recommended to modify the default template, rather
    | create a new template. If you modify the default template and then
    | executed 'php artisan vendor:publish' command, will override your changes!
    |
     */
    'template' => 'boiler-plate',

];
