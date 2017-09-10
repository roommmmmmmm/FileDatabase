<?php
/**
 * 缓存文件读取类
 * @author wenziyue@myhexin.com
 */
class Public_File_Op
{
	/**
	 * 文件对象数组
	 * @var array
	 */
	private static $_fileobjs = array();
	
	/**
	 * 数据根目录
	 * @var string
	 */
	private static $_dataroot;
		
	/**
	 * 获取数据根目录
	 */
	public static function getDataroot()
	{
		if (empty(self::$_dataroot)) {
			self::$_dataroot = PROJECT_PATH . '/data/datafile/';
		}
		return self::$_dataroot;
	}
	
	/**
	 * 根据文件编号，获取文件对象
	 * @param string $fileno
	 */
	public static function _($fileno)
	{
		if (!isset(self::$_fileobjs[$fileno])) {
			// 获取目标文件的相关配置：类型、编号
			$fileinfo = self::_getfileinfo($fileno);
			if (!$fileinfo) {
				return null;
			}
			// 实例化文件对象
			$classname = "Public_File_" . ucfirst($fileinfo['type']);
			self::$_fileobjs[$fileno] = new $classname($fileinfo['path']);
		}
		return self::$_fileobjs[$fileno];
	}
	
	/**
	 * 获取文件名
	 * @param unknown $fileconf
	 */
	private static function _getfileinfo($fileno)
	{	
		$confkey = "admin.file.{$fileno}";
		$fileconf = Public_File_Conf::get($confkey);
		if (empty($fileconf)) {
			return false;
		}
		$data['name'] =  $fileconf['name'] . '_' . $fileconf['type'] . '_' . $fileconf['no'];
		switch ($fileconf['type']) {
			case 'inc' :
				$data['name'] .= '.inc';
				break;
			default :
				break;
		}
		$data['path'] = self::getDataroot() . $data['name'];
		$data['type'] = $fileconf['type'];
		return $data;
	}
	
	/**
	 * 获取文件名
	 */
	public static function getFileName($fileno)
	{
		$data = self::_getfileinfo($fileno);
		if ($data) {
			return $data['name'];
		}
		return false;
	}
}