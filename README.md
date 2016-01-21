# LOGGER

A terrible logger utility for PHP.

## Example

```php
<?php
require __DIR__.'/logger.php';

# logger is active based on truthiness of an expression
$debug = logger('./debug.log', getenv('PHP_ENV') === 'TEST');
$debug('This will show up if PHP_ENV is set to TEST');

# logger is active based result of callable
$info = logger('./info.log', function () {
  return true;
});
$info('This should show up');

# works like printf
$name = 'noodlehaus';
$info('Hello there %s', $name);

# defaults
$always = logger('./file.log');
$always('This always gets logged.');
```

## License

MIT <http://noodlehaus.mit-license.org>
