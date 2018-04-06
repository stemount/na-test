#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

sudo chmod u+s /usr/sbin/ntpdate
sudo timedatectl set-timezone GMT
ntpdate -u ntp.ubuntu.com

cd code
composer install
php artisan migrate

echo "The project is now available at http://noagent-test"
