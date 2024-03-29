<?php
/**
 * Database of the docker demo site
 * Copyright (C) 2016  Marcos Zuriaga Miguel <wolfi at wolfi.es>
 * Copyright (C) 2016  Sander Brand <brantje at gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
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
                <a class="btn btn-primary btn-xl page-scroll" href="https://demo.passman.cc:<?=$port?>">Go to demo!</a>
            </p>
        <?php } ?>
    </div>
</div>
<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    // tracker methods like "setCustomDimension" should be called before "trackPageView"
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//stats.passman.cc/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<!-- End Piwik Code -->
</body>
</html>