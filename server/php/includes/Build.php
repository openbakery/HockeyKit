<?

class Build {

	public $version;
	public $size;
	public $downloadURL;
	public $ipa;
	public $plist;
	public $html;
	public $team;
	public $mandatory;

	public function __toString() {
   return "Build[version=" . $this->version . " downloadURL=" . $this->downloadURL . "]";
 	}


	function formatedSize()
	{
	  $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	  return $this->size ? round($this->size/pow(1024, ($i = floor(log($this->size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
	}
	
	function releaseDate() {
		return filectime($this->ipa);
	}


}

?>