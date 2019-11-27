<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Src\Database;
use Src\Product;
use Src\Api;

$dotenv = new DotEnv(__DIR__);
$dotenv->load();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    $database = new Database(
        getenv('DB_HOST'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        getenv('DB_NAME'),
        getenv('DB_PORT')
    );

    $product = new Product($database);

    $api = new Api($product);
    $api->run();
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
