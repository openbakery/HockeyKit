<?


// for now the application class is a adapter to the router class but in the future the this class should completly replace the router
class Application {
	
	public $builds;
	public $baseURL;
	public $path;
	public $directory;
	public $image;
	public $notes;
	public $title;
	public $subtitle;
	public $platform;
	
	
	public static function create($applicationDirectory, $device = null) {
		$router = Router::get(array('appDirectory' => $applicationDirectory));
		$applications = array();
		
		foreach ($router->app->applications as $i => $applicationInfo) {
			
			//print_r($applicationInfo['allVersions']);
			//echo "<br><br><br>";
			
			$application = new Application();
			$application->baseURL = $router->baseURL;
			$application->path = $applicationInfo['path'];
			$application->image = $applicationInfo[AppUpdater::INDEX_IMAGE];
			$application->notes = $applicationInfo[AppUpdater::INDEX_NOTES];
			$application->title = $applicationInfo[AppUpdater::INDEX_APP];
			$application->subtitle = $applicationInfo[AppUpdater::INDEX_SUBTITLE];
			$application->platform = $applicationInfo[AppUpdater::INDEX_PLATFORM];
			$application->directory = $applicationInfo[AppUpdater::INDEX_DIR];

			$application->builds = array();
			
			foreach ($applicationInfo[AppUpdater::INDEX_ALL_VERSIONS] as $version => $versionInfo) {
				$build = new Build();
				$build->version = $version;
				$build->size = $applicationInfo[AppUpdater::INDEX_APPSIZE];
				$build->ipa = $versionInfo['.ipa'];
				$build->plist = $versionInfo['.plist'];
				$build->html = $versionInfo['.html'];
				$build->team = $versionInfo['.team'];
				$build->mandatory = $versionInfo['.mandatory'];
				
				if ($device->os == 'iOS') {
					$downloadURL = $application->baseURL . 'api/2/apps/' . $application->directory . '?format=plist&version=' . $build->version;
					$build->downloadURL = "itms-services://?action=download-manifest&amp;url=" . urlencode($downloadURL);
				} else {
					$build->downloadURL = $application->baseURL . $application->directory . '/' . $build->version . '/' . basename($build->ipa);
				}
				$application->builds[] = $build;
			}
			
			$applications[] = $application;
		}
		return $applications;
	}
	
	public function __construct() {
		
	}
	
}

?>