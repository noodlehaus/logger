<?php
namespace badphp\logger;

function create($path, $cond = true) {

  $fd = fopen($path, 'a+');

  if ($fd === false) {
    trigger_error(
      __FUNCTION__.": Failed to create [$path]",
      E_USER_ERROR
    );
  }

  $writer = function () use ($fd) {

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

    return fwrite($fd, $msg.PHP_EOL);
  };

  if (is_callable($cond)) {
    return function () use ($fd, $cond, $writer) {
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

  return function () use ($fd, $writer) {
    return call_user_func_array($writer, func_get_args());
  };
}
