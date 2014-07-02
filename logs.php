<?php
namespace noodlehaus\logs;

function logger($path, $condition = null) {

  $condition = $condition ? $condition : function () { return true; };

  if (!is_callable($condition))
    trigger_error(
      "logs\logger(): Second argument has to be a callable",
      E_USER_ERROR
    );

  if (!file_exists($path)) {
    !@touch($path) && trigger_error(
      "Unable to create log file [{$path}].",
      E_USER_ERROR
    );
  }

  if (!is_writable($path))
    trigger_error(
      "logs\logger(): Log file [{$path}] is not writeable!",
      E_USER_ERROR
    );

  if ($condition() !== true)
    return function () {};

  return function ($sfmt) use ($path) {
    $argv = func_get_args();
    $mesg = call_user_func_array('sprintf', $argv);
    error_log($mesg."\r\n", 3, $path);
  };
}
