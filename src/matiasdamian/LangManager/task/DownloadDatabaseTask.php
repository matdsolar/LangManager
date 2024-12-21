<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\task;

use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Internet;
use pocketmine\utils\InternetRequestResult;
use pocketmine\utils\Filesystem;

use matiasdamian\LangManager\Main;
use matiasdamian\LangManager\LangManager;

/**
 * Handles downloading the MaxMind GeoLite2-Country database asynchronously.
 */
class DownloadDatabaseTask extends AsyncTask{
	
	public function __construct(){
		//NOOP
	}
	
	/**
	 * Runs the task.
	 * @return void
	 */
	public function onRun(): void{
		$url = Main::MAXMIND_DB_RESOURCE_URL;
		$result = Internet::getURL($url);
		
		if($result instanceof InternetRequestResult && $result->getBody() !== ""){
			$this->setResult($result->getBody());
			return;
		}
		$this->setResult(null);
	}
	
	public function onCompletion(): void{
		$result = $this->getResult();
		$plugin = LangManager::getInstance()?->getPlugin();
		
		if($plugin === null){
			return;
		}
		
		if($result !== null){
			$this->saveDatabase($plugin, $result);
			return;
		}
		$plugin->getLogger()->error("Failed to download MaxMind GeoLite2-Country database.");
	}
	
	/**
	 * Saves the database file and updates plugin configuration.
	 *
	 * @param Main $plugin The main plugin instance.
	 * @param string $data The downloaded database content.
	 */
	private function saveDatabase(Main $plugin, string $data): void{
		$dataPath = $plugin->getDataFolder() . Main::MAXMIND_DB_RESOURCE;
		
		Filesystem::safeFilePutContents($dataPath, $data);
		$plugin->getLogger()->info("MaxMind GeoLite2-Country database downloaded successfully.");
		
		// Save resource to plugin data folder and update configuration
		$plugin->saveResource(Main::MAXMIND_DB_RESOURCE, true);
		$plugin->getConfig()->set("maxmind-db-version", Main::MAXMIND_DB_RELEASE);
		LangManager::getInstance()?->initializeGeoIpReader();
	}
}