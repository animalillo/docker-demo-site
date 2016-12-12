#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(dirname "$SCRIPT")

# Load configuration
source $SCRIPTPATH/daemon_config

# Sets up the autostart features on rc.d and init.d to launch the daemon on boot
function install_autostart() {
	# Copy the script to the init scripts
	cp $SCRIPTPATH/initd.sh /etc/init.d/demo_site

	# Insert absolute path to this file
	sed -i "s|DAEMON_PATH|$SCRIPT|g" /etc/init.d/demo_site

	# Enable rc.d autorun of the daemon
	update-rc.d demo_site defaults
	update-rc.d demo_site enable
}

# Runs the actual daemon and restarts it in case it fails
function daemon(){
	while (true); 
	do 
		php $SCRIPTPATH/index.php Daemon  >> $LOG_PATH 2>&1 
		sleep 2
	done
}

# Deletes the autostart from rc levels and init script
function remove_autostart() {
	rm /etc/init.d/demo_site
	update-rc.d demo_site remove
}

case "$1" in
	install)
		install_autostart
	;;
	daemon)
		case "$2" in
			pidfile)
				echo $$ > $3
			;;
		esac
		daemon
	;;
	uninstall)
		remove_autostart
	;;
	*)
		echo "usage: daemon.sh install|uninstall|daemon";
		echo "This script must be run as root!";
esac
