<?php
    session_start();
    require_once "vendor/autoload.php";
    require_once "config/config.php";

    require_once __DIR__.'/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    
    use Controllers\FrontController;
    FrontController::main();


?>

