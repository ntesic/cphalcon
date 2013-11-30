<?php

/*
  +------------------------------------------------------------------------+
  | Phalcon Framework                                                      |
  +------------------------------------------------------------------------+
  | Copyright (c) 2011-2012 Phalcon Team (http://www.phalconphp.com)       |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file docs/LICENSE.txt.                        |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Authors: Andres Gutierrez <andres@phalconphp.com>                      |
  |          Eduar Carvajal <eduar@phalconphp.com>                         |
  |          Vladimir Kolesnikov <vladimir@extrememember.com>              |
  +------------------------------------------------------------------------+
*/

class BeanstalkTest extends PHPUnit_Framework_TestCase
{
	public function testMemory()
	{
		$queue = new Phalcon\Queue\Beanstalk();
		try {
			@$queue->connect();
		}
		catch (Exception $e) {
			$this->markTestSkipped("Unable to connect to beanstalkd");
			return;
		}

		$expected = array('processVideo' => 4871);

		$queue->put($expected);
		while (($job = $queue->peekReady()) !== false) {
			$actual = $job->getBody();
			$job->delete();
			$this->assertEquals($expected, $actual);
		}
	}
}
