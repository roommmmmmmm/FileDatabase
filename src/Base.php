<?php
namespace File;
/**
 * 文件类基类
 */
abstract class Base
{
	/**
	 * 文件全路径
	 * @var string
	 */
	private $_fullpath;

	/**
	 * 文件内容在内存中的缓存
	 * @var string
	 */
	private $_cache;

	/**
	 * 文件内容缓存的有效性
	 * @var bool
	 */
	private $_isvalid;

	/**
	 * 构造函数，传入文件路径
	 * @param string $_fullpath
	 */
	public function __construct($_fullpath)
	{
		$this->setFullpath($_fullpath);
		$this->_isvalid = false;
	}

	/**
	 * 设置文件路径
	 * @param string $_fullpath
	 */
	public function setFullpath($_fullpath = '')
	{
		$this->_fullpath = $_fullpath;
	}

	/**
	 * 取得文件路径
	 * @return string
	 */
	public function getFullpath()
	{
		return $this->_fullpath;
	}


	/**
	 * 判断文件是否存在
	 * @return boolean
	 */
	public function exists()
	{
		return file_exists($this->getFullpath());
	}


	/**
	 * 删除文件
	 */
	public function remove()
	{
		unlink($this->getFullpath());
	}


	/**
	 * 返回创建时间
	 */
	public function getCtime($format = '')
	{
		$filepath = $this->getFullpath();
		if (file_exists($filepath)) {
			$timestamp = filectime($filepath);
			$ctime = !empty($format) ? date($format, $timestamp) : $timestamp;
			return $ctime;
		}
		return false;
	}

	/**
	 * 返回上次访问时间
	 */
	public function getAtime($format = '')
	{
		$filepath = $this->getFullpath();
		if (file_exists($filepath)) {
			$timestamp = fileatime($filepath);
			$ctime = !empty($format) ? date($format, $timestamp) : $timestamp;
			return $ctime;
		}
		return false;
	}

	/**
	 * 返回上次修改时间
	 */
	public function getMtime($format = '')
	{
		$filepath = $this->getFullpath();
		if (file_exists($filepath)) {
			$timestamp = filemtime($filepath);
			$ctime = !empty($format) ? date($format, $timestamp) : $timestamp;
			return $ctime;
		}
		return false;
	}

	/**
	 * 读取文件内容
	 */
	public function readfile()
	{
		if ($this->_isvalid) {
			return $this->_cache;
		}
		$filepath = $this->getFullpath();
		if (file_exists($filepath)) {
			$this->_cache = file_get_contents($filepath);
			$this->_isvalid = true;
			return $this->_cache;
		}
		return null;
	}

	/**
	 * 写文件内容
	 */
	public function writefile($content)
	{
		$filepath = $this->getFullpath();
		$dirname = dirname($filepath);
		if (!is_dir($dirname)) {
// 			@mkdir($dirname, 0777, true);
			return false;
		}
		if (!file_exists($filepath)) {
			touch($filepath);
		}
		if (false === file_put_contents($filepath, $content, LOCK_EX)) {
			return false;
		}
		$this->_isvalid = false;
		return true;
	}

	/**
	 * 抽象读接口
	 */
	abstract public function read();
	/**
	 * 抽象写接口
	 */
	abstract public function write();
}
