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

  public function testLoggerCondition() {

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

  public function testLoggerInvalidCondition() {
    $this->setExpectedException('PHPUnit_Framework_Error');
    $logger = logs\logger(self::LOGFILE, true);
  }
}
