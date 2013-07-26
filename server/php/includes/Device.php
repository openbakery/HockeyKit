<?php


class Device {
	public $name; // iPad, iPhone
	public $version; // version number of the OS
	public $os; // e.g. iOS, Android
	
	
	public function __construct($name, $version, $os) {
		$this->name = $name;
		$this->version = $version;
		$this->os = $os;
	}
	
	public function majorVersion() {
		return intval($this->version);
	}
	
	
	private static function detectVersion($agentString) {
		$pattern = '/CPU( \w+)? OS (?P<version>\d+_\d+)/';
		preg_match($pattern, $agentString, $matches, PREG_OFFSET_CAPTURE);
		if ($matches['version'][0]) {
			return str_replace('_', '.', $matches['version'][0]);
		}
		return "unknown";
	}

	public static function detect()
  {
		$agent = $_SERVER['HTTP_USER_AGENT'];

		$name = "unknown";
		$version = "unknown";
		$os = "unknown";

		if (strpos($agent, 'iPad') !== false) {
			$name = "iPad";
			$os = "iOS";
			$version = Device::detectVersion($agent);
		} else if (strpos($agent, 'iPhone') !== false) {
			$name = "iPhone";
			$os = "iOS";
			$version = Device::detectVersion($agent);
		} else if (strpos($agent, 'Android') !== false) {
    	$os = "Android";
		}
		return new Device($name, $version, $os);
	}
	
}


?>