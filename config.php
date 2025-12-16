<?php
// Database credentials for hosting (InfinityFree / cPanel)
// Fill these from your hosting control panel when deploying.
// Example InfinityFree values:
// $DB_HOST = 'sqlXXX.epizy.com';
// $DB_USER = 'epiz_XXXXXXXX';
// $DB_PASS = 'your_password';
// $DB_NAME = 'epiz_XXXXXXXX_portfolio';

$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'portfolio';
