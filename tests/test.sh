#/!bin/bash

log=/tmp/test.dump
echo > $log

rm -rf vendor
rm -rf composer.lock
composer install --dev
/usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests >> $log 2>&1
echo $?