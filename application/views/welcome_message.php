<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>Welcome to Passman!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?= base_url('resources/css/bootstrap.min.css'); ?>">

    <!-- Optional theme -->
    <link rel="stylesheet" href="<?= base_url('resources/css/bootstrap-theme.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('resources/css/main.css'); ?>" media="screen">

    <!-- Latest compiled and minified JavaScript -->
    <script src="<?= base_url('resources/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('resources/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('resources/js/main.js'); ?>"></script>
    <script>
        var post_url = "<?= site_url('Welcome/createContainer') ?>";
        var status_url = "<?= site_url('Welcome/instanceReady') ?>";
    </script>
</head>

<body id="page-top">



<header class="layer">

</header>
<header>
</header>
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
            <small>Setting up an instance takes about 15 seconds, please be patient.</small>
            <p>
            <form id="form">
                <?= $recaptcha_html; ?>
                <input type="button" id="create" class="btn btn-primary btn-xl page-scroll" value="Create container" />
            </form>

            <span>
                    Status:
                </span>
            <span id="status">
                    Not running
                </span>
            <i class="ellipsis">
                <i>.</i>
                <i>.</i>
                <i>.</i>
                <i>.</i>
                <i>.</i>
            </i>
            </p>
        <?php } else { ?>
            <p>
                <a class="btn btn-primary btn-xl page-scroll" href="http://demo.passman.cc:<?=$port?>">Go to demo!</a>
            </p>
        <?php } ?>
    </div>
</div>
</body>
</html>