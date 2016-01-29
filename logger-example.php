<?php
require __DIR__.'/logger.php';

# use default priority = LOG_ERR and prefix map
$log = logger('./app.log');
$log(LOG_INFO, 'Application started.');
$log(LOG_NOTICE, 'Hostname is %s', 'foo');
$log(LOG_DEBUG, '1 + 1 is 2');
$log(LOG_ERR, 'OMG something went wrong!');

# more verbose logging, change some entry prefixes
$debug = logger('./app.log', LOG_DEBUG, [
  LOG_DEBUG => 'LOOK_AT_THIS'
]);

$debug(LOG_ERR, 'OMG the server is on fire!');
$debug(LOG_DEBUG, 'We should check if the server is on fire');
