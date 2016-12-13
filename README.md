Docker demo Site
================
With this tool you can easeily get a demo server for your awesome web application
up and running very easily. Just setup your desired docker to run all the services
for your application and feed that docker to this application.

This will create docker instances, open the docker port to the public and then destroy it and close that port after a given time.

Re-captcha keeps it safe from bot abuse and per-ip instance keeps it safe of human abuse, also adding a neat way of returning to your instance if you accidentally close the browser.

This simplifies the development of demo sites a lot:
- You don't need to worry about cleaning your database and restoring bacups.
- You don't need to worry about cleaning up user created files or uploads.
- You don't need to worry about any system changes made by the application.

Enjoy!

Setup
=====
1. Site and daemon main configuration:
  > cd application/config/
  >
  > cp config.php.example config.php
  >
  > cp database.php.example daabase.php
  >
  > cd ../../

1. Main configuration:
  - Edit *application/config/databaser.php* to your desired database setup
  - Edit *application/config/config.php* to reflect your site url. Mind the $['docker_command'] changing it to the appropiate one for your demo needs.

1. Setup composer dependencies
  > cd application/helpers/composer
  >
  > ./composerh.phar install
  >
  > cd ../../../

1. Setup daemon configuration:
  > cp daemon_config.example daemon_config

1. Edit *daemon_config* variables to reflect your desired setup

1. Optional: Setup init script
  > sudo ./daemon.sh install

1. Congratulations! Everything is ready for your demos to run on demand!

To run the daemon
=================
- development run
  > sudo php index.php Daemon

- production run
  > sudo ./daemon.sh daemon

- If installed as init script, it will autostart at boot time
  > service demo_site start

Uninstalling the init script
============================
 > sudo ./daemon.sh uninstall
