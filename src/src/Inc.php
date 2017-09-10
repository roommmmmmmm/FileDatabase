<?php
/**
 * inc文件类
 * @author wenziyue@myhexin.com
 */
class Public_File_Inc extends Public_File_Base
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
			//5.3.5版本的php对匹配内容的大小有限制，大于一定量直接返回false 固停用此匹配
			/*$matches = null;
			if (preg_match_all('/\<\?php[\s]+(return[\s]+[\s\S]*?)(\?\>)?$/', $content, $matches)) {
				return eval($matches[1][0]);
			} else {
				return null;
			}*/
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