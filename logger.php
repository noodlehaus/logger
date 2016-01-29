<?php

# @license MIT

# Creates logger callable
function logger($path, $prio = LOG_ERR, $pmap = []) {

  $pref = $pmap + [
    LOG_EMERG => 'EMERGENCY',
    LOG_ALERT => 'ALERT',
    LOG_CRIT => 'CRITICAL',
    LOG_ERR => 'ERROR',
    LOG_WARNING => 'WARNING',
    LOG_NOTICE => 'NOTICE',
    LOG_INFO => 'INFO',
    LOG_DEBUG => 'DEBUG',
  ];

  $base = dirname($path);
  if ($base !== '.' && !file_exists($base)) {
    throw new InvalidArgumentException("Directory {$base} doesn't exist.");
  }

  if (touch($path) === false) {
    throw new InvalidArgumentException("Unable to create log file {$path}.");
  }

  return function ($level, $text, ...$args) use ($path, $prio, $pref) {
    if ($level <= $prio) {
      $t = strftime('%Y-%m-%d %H:%M:%S');
      $s = sprintf('[%s] %s: '.$text.PHP_EOL, $t, $pref[$level], ...$args);
      file_put_contents($path, $s, LOCK_EX|FILE_APPEND);
    }
  };
}
