<?php
namespace File;
use File\Base;
/**
 * 序列化文件类
 */
class Serialize extends Base
{
	/**
	 * 序列化文件读接口
	 * @see Public_File_Base::read()
	 */
	public function read()
	{
		$content = $this->readfile();
		if (false !== $content) {
			return unserialize($content);
		}
		return false;
	}

	/**
	 * 序列化文件写函数
	 * @see Public_File_Base::write()
	 */
	public function write($content = '')
	{
		$content = serialize($content);
		return $this->writefile($content);
	}
}
