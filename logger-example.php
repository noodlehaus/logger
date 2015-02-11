<?php
require __DIR__.'/logger.php';

use badphp\logger;

# logger is active based on truthiness of an expression
$debug = logger\create('./debug.log', getenv('PHP_ENV') === 'TEST');
$debug('This will show up if PHP_ENV is set to TEST');

# logger is active based result of callable
$info = logger\create('./info.log', function () {
  return true;
});
$info('This should show up');

# defaults
$always = logger\create('./file.log');
$always('This always gets logged.');
