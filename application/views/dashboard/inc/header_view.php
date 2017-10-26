<!DOCTYPE html>
<html lang="en">
    <head>
        <title>jrDash</title>
        <link rel="stylesheet" href="<?= base_url() ?>public/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/css/style.css">

        <script src="<?= base_url() ?>public/js/jquery.js"></script>
        <script src="<?= base_url() ?>public/js/bootstrap.min.js"></script>
        
        <script src="<?= base_url() ?>public/js/jrdash/dashboard/result.js"></script>
        <script src="<?= base_url() ?>public/js/jrdash/dashboard/event.js"></script>
        <script src="<?= base_url() ?>public/js/jrdash/dashboard/template.js"></script>
        <script src="<?= base_url() ?>public/js/jrdash/dashboard.js"></script>
    </head>
    <body>

        <nav class="navbar">
            <div class="navbar-inner">
                <span class="brand">jrDash</span>
                <ul class="nav">
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">User</a></li>
                    <li><a href="<?= site_url('dashboard/logout') ?>">Logout</a></li>
                </ul>
            </div>
        </nav>

        <div class="wrapper">