<?php
/**
 * 配置不存在的时候
 * @author wenziyue@myhexin.com
 */
class Public_File_Null extends Public_File_Base
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