# LOGS

[![Build Status](https://travis-ci.org/noodlehaus/logs.svg)](https://travis-ci.org/noodlehaus/logs)
[![Coverage Status](https://coveralls.io/repos/noodlehaus/logs/badge.png?branch=master)](https://coveralls.io/r/noodlehaus/logs?branch=master)

Simple file logger for your application.

## Example

```php
<?php
require __DIR__.'/logs.php';

use noodlehaus\logs;

# logger is active based on a getenv() value
$debug = logs\logger('./debug.log', function () {
  return (getenv('PHP_ENV') === 'TEST');
});
$debug('This will show up if PHP_ENV is set to TEST');

# logger is active based on truthiness of an expression
$debug = logs\logger('./debug.log', getenv('PHP_ENV') === 'TEST');
$debug('This will show up if PHP_ENV is set to TEST');

# logger is active based on define()
$info = logs\logger('./info.log', function () {
  return (defined('SHOW_INFO') && (SHOW_INFO === true));
});
$info('This will show up if you have define(\'SHOW_INFO\', true)');

# defaults
$always = logs\logger('./file.log');
$always('This always gets logged.');
```

## License

MIT <http://noodlehaus.mit-license.org>
