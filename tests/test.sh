#/!bin/bash

LOG_FILE_NAME=$1
if [ -z "$LOG_FILE_NAME" ]; then
	LOG_FILE_NAME='test.dump'
fi;
log=/tmp/$LOG_FILE_NAME
echo > $log

rm -rf vendor
rm -rf composer.lock
COMPOSER_NO_DEV=0 composer install
rm -rf /tmp/GalleryBundle

/usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests >> $log 2>&1
status=$(cat $log | grep "ERRORS!")
[ -z "$status" ] && exit 0 ||  exit -1