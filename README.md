Setup
=========================
1. Site and daemon main configuration:
  > cd application/config/
  >
  > cp config.php.example config.php
  >
  > cp database.php.example daabase.php
  >
  > cd ../../

1. Edit *application/config/databaser.php* and *application/config/config.php* to reflect your site configuration

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

To run the daemon
==============
- development run
  > sudo php index.php Daemon

- production run
  > sudo ./daemon.sh daemon

- If installed as init script, it will autostart at boot time
  > service demo_site start
