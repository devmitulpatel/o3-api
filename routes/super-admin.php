<?php

Route::get('/', function () {
    return 'super admin';
});

Route::get('test', 'TestController');
