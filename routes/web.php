<?php

use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Route;

Route::get('/', function (GeneralSettings $settings){
    // return app(GeneralSettings::class)->site_name;
    // dd($settings);
    return [
        'site_name' => $settings->site_name,
    ];
});
