#!/bin/bash
ln -sf ../../../../simplesaml/config vendor/simplesamlphp/simplesamlphp/
ln -sf ../../../../simplesaml/cert vendor/simplesamlphp/simplesamlphp/
touch vendor/simplesamlphp/simplesamlphp/modules/cron/enable
touch vendor/simplesamlphp/simplesamlphp/modules/metarefresh/enable
chown www-data:www-data vendor/simplesamlphp/simplesamlphp/metadata -R
