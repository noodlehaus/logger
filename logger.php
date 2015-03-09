<?php
namespace badphp\logger;

function create($path, $cond = true) {

  $writer = function () use ($path) {

    $args = func_get_args();
    $argn = count($args);

    if (!$argn) {
      return false;
    }

    if ($argn > 1) {
      $msg = call_user_func_array('sprintf', $args);
    } else {
      $msg = array_shift($args);
    }

    return error_log($msg."\n", 3, $path);
  };

  if (is_callable($cond)) {
    return function () use ($cond, $writer) {
      if (!$cond()) {
        return false;
      }
      return call_user_func_array($writer, func_get_args());
    };
  }

  $cond = !!$cond;

  if (!$cond) {
    return function () {
      return true;
    };
  }

  return function () use ($writer) {
    return call_user_func_array($writer, func_get_args());
  };
}
