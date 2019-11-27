<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Src\Database;

$dotenv = new DotEnv(__DIR__);
$dotenv->load();

try {
    $database = new Database(
        getenv('DB_HOST'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        getenv('DB_NAME'),
        getenv('DB_PORT')
    );

    $link = $database->getLink();

    $sql = "
        DROP TABLE IF EXISTS `product`;
        CREATE TABLE `product` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `price` decimal(12,2) DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

        INSERT INTO `product` (name, price) VALUES ('Milk', 0.57), ('Bread', 1.12), ('Coffee', 14.21);
    ";
    $link->exec($sql);

    echo "You have successfully created product table. Please, remove install.php.";
} catch (\Exception $e) {
    echo $e->getMessage();
}
