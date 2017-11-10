<!DOCTYPE html>
<html lang="en">
    <head>
        <title>jrDash</title>
        <link rel="stylesheet" href="<?= base_url() ?>public/third-party/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/css/style.css">

        <script src="<?= base_url() ?>public/third-party/js/jquery.js"></script>
        <script src="<?= base_url() ?>public/third-party/js/bootstrap.min.js"></script>
        
        <script src="<?= base_url() ?>public/js/dashboard/result.js"></script>
        <script src="<?= base_url() ?>public/js/dashboard/event.js"></script>
        <script src="<?= base_url() ?>public/js/dashboard/template.js"></script>
        <script src="<?= base_url() ?>public/js/dashboard.js"></script>
        
        <script>
        $(function() {
            var dashboard = new Dashboard();
        });    
        </script>
    </head>
    <body>

        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <span class="brand">jrDash</span>
                    <ul class="nav">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">User</a></li>
                        <li><a href="<?= site_url('dashboard/logout') ?>">Logout</a></li>
                    </ul>                    
                </div>
            </div>
        </div>

        <div class="container">
            
            <div id="error" class="alert alert-danger hide"></div>
            <div id="success" class="alert alert-success hide"></div>