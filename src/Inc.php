<?php
namespace File;
use File\Base;
/**
 * inc文件类
 */
class Inc extends Base
{
	/**
	 * 读inc文件内容
	 * @see Public_File_Base::read()
	 */
	public function read($fromopcache = true)
	{
		if ($fromopcache) {
			$filepath = $this->getFullpath();
			if (file_exists($filepath)) {
				return include $filepath;
			} else {
				return null;
			}
		} else {
			$content = $this->readfile();
			if (substr($content, 0, 5) == "<?php") {
				$content = ltrim($content, "<?php");
				$content = rtrim($content, "?>");
				return eval($content);
			} else {
				return null;
			}
		}
	}

	/**
	 * 写inc文件
	 * @see Public_File_Base::write()
	 */
	public function write($content = '')
	{
		$content = '<?php return ' . var_export($content, true) . ';';
		if (substr_compare($content, "););", -4, 4) == 0) {
			return false;
		} else {
			return $this->writefile($content);
		}

	}
}
