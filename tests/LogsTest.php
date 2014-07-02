<?php
use noodlehaus\logs;

class LogsTest extends PHPUnit_Framework_TestCase {

  const LOGFILE = './logfile.log';

  public function setUp() {
    touch(self::LOGFILE);
  }

  public function tearDown() {
    unlink(self::LOGFILE);
  }

  public function testLoggerDefault() {

    $logger = logs\logger(self::LOGFILE);
    $logger('LoggerDefault');

    $this->assertEquals(
      'LoggerDefault',
      trim(file_get_contents(self::LOGFILE))
    );
  }

  public function testLoggerConditionCallable() {

    $logger1 = logs\logger(self::LOGFILE, function () {
      return (getenv('PHP_ENV') === 'TEST');
    });
    $logger1('LoggerCondition');
    $this->assertEquals('', trim(file_get_contents(self::LOGFILE)));

    putenv('PHP_ENV=TEST');
    $logger2 = logs\logger(self::LOGFILE, function () {
      return (getenv('PHP_ENV') === 'TEST');
    });
    $logger2('LoggerCondition');
    $this->assertEquals(
      'LoggerCondition',
      trim(file_get_contents(self::LOGFILE))
    );
  }

  public function testLoggerConditionBoolean() {

    $logger1 = logs\logger(self::LOGFILE, false);
    $logger1('LoggerCondition');
    $this->assertEquals('', trim(file_get_contents(self::LOGFILE)));

    $logger2 = logs\logger(self::LOGFILE, true);
    $logger2('LoggerCondition');
    $this->assertEquals(
      'LoggerCondition',
      trim(file_get_contents(self::LOGFILE))
    );
  }

  public function testLoggerInvalidPath() {
    $this->setExpectedException('PHPUnit_Framework_Error');
    $logger = logs\logger('/some/invalid/path');
  }

  public function testLoggerInvalidFile() {
    $file_ro = __DIR__.'/readonly.log';
    if (!file_exists($file_ro)) {
      touch($file_ro);
      chmod($file_ro, 0444);
    }
    $this->setExpectedException('PHPUnit_Framework_Error');
    $logger = logs\logger(__DIR__.'/readonly.log');
  }

  public function testLoggerFreshFile() {
    @unlink($path = './fresh.log');
    $logger = logs\logger($path);
    $logger('FreshFile');
    $this->assertEquals(
      'FreshFile',
      trim(file_get_contents($path))
    );
    unlink($path);
  }
}
