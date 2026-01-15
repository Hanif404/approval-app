<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

# Load phpdotenv
require 'vendor/autoload.php';

$hook['pre_system'][] = function() {
    // Use FCPATH if your .env file is in the project root
    $dotenv = Dotenv\Dotenv::create(APPPATH);
    $dotenv->load();
};
