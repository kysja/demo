<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Yantramanav&display=swap" rel="stylesheet">

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.6.3.min.js"></script>
    <script src="/js/main.js"></script>

    <title><?= $title ?? $viewGlobal['title'] ?></title>
</head>
<body class="d-flex flex-column h-100">
<?php require 'flash.php'; ?>
    

<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <img src="/images/logo.png">
            <span class="fs-3 fw-bold ms-3"><?= $viewGlobal['title'] ?></span>
        </a>

        <?php require 'nav.php'; ?>

    </header>
</div>


<main class="flex-shrink-0">
    <div class="container">