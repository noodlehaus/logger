<?php
function logger($path, $condition = true) {

  $writer = function (...$args) use ($path) {
    $argn = count($args);
    if (!$argn) {
      return false;
    }
    $msg = ($argn > 1 ? sprintf(...$args) : array_shift($args));
    return error_log($msg."\n", 3, $path);
  };

  if (is_callable($condition)) {
    return function (...$args) use ($condition, $writer) {
      if (!$condition()) {
        return false;
      }
      return $writer(...$args);
    };
  }

  $condition = !!$condition;

  if (!$condition) {
    return function () { return true; };
  }

  return function (...$args) use ($writer) {
    return $writer(...$args);
  };
}
