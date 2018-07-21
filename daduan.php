<?php
/**
 * 智能机器人服务流程
 * 2018-2-2 15:19:09
 * loonghere@qq.com
 */

class Robot
{
	public function run()
	{
		$input = trim(file_get_contents("php://input"));
		$input = json_decode($input, true);
		$inline = require 'config/inline.php';
		$version = isset($inline[$input['callerid']]['version']) ? $inline[$input['callerid']]['version'] : 'v1';
		require 'daduan.' . $version . '.php';
	}
}

$robot = new Robot;
$robot->run();