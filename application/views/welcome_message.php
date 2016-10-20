<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Passman!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?= base_url('resources/css/bootstrap.min.css'); ?>">

    <!-- Optional theme -->
    <link rel="stylesheet" href="<?= base_url('resources/css/bootstrap-theme.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('resources/css/main.css'); ?>" media="screen">

    <!-- Latest compiled and minified JavaScript -->
    <script src="<?= base_url('resources/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('resources/js/bootstrap.min.js'); ?>"></script>
</head>

<body id="page-top">



<header>
    <div class="header-content">
        <div class="header-content-inner">
            <h1 id="homeHeading">Try passman </h1>
            <hr>
            <p><b>O</b>nce you click the following button you will be to a newly created
                Nextcloud instance only for you, with passman installed on it. <br>
                It will only be alive for an hour (1) and after that it will go into void. Meanwhile
                you can do anything you want with it, have fun!</p>
            <p>
                The default username and password are:
                <br />
                Username: admin <br>
                Password: admin
            </p>
            <?php if ($running_demo) { ?>
            <p>
                Your demo has <?= $time_left ?> seconds left before it goes to the VOID
            </p>
            <?php } ?>
            <?php if (!$running_demo) { ?>
                <p>
                <form method="POST" action="<?= site_url('Welcome/createContainer') ?>">
                    <?= $recaptcha_html; ?>
                    <input type="submit" class="btn btn-primary btn-xl page-scroll" value="Create container" />
                </form>
                </p>
            <?php } else { ?>
                <p>
                    <a class="btn btn-primary btn-xl page-scroll" href="http://demo.passman.cc:<?=$port?>">Go to demo!</a>
                </p>
            <?php } ?>
        </div>
    </div>
</header>

<!--
<div id="container">
	<h1>Welcome to Passman demos!</h1>

	<div id="body">
		<p>
                    The demo is ready,
                </p>
                <p>
                    You can even create accounts and share the url with your friends and try sharing!
                </p>

	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
-->
</body>
</html>