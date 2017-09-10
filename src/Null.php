<?php
namespace File;
use File\Base;
/**
 * 配置不存在的时候
 */
class Null extends Base
{

	public function read($a)
	{
		return null;
	}

	public function write($a)
	{
		return null;
	}
}
