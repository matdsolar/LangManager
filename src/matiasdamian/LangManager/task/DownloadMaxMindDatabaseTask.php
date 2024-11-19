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
 * Class DownloadMaxMindDatabaseTask
 * Downloads the MaxMind GeoLite2-Country database file.
 */
class DownloadMaxMindDatabaseTask extends AsyncTask
{

    public function __construct() {}

    /**
     * Runs the task.
     * @return void
     */
    public function onRun(): void
    {
        $result = Internet::getURL(Main::MAXMIND_DB_RESOURCE_URL);
        if ($result instanceof InternetRequestResult && $result->getBody() !== "") {
            $this->setResult($result->getBody());
        }
    }

    public function onCompletion(): void
    {
        $result = $this->getResult();
        $plugin = LangManager::getInstance()?->getPlugin();
        if ($result !== null) {
			Filesystem::safeFilePutContents(
				Main::getInstance()->getDataFolder() . Main::MAXMIND_DB_RESOURCE,
				$result
			);
            $plugin->getLogger()->info("MaxMind GeoLite2-Country database downloaded.");
            $plugin->saveResource(Main::MAXMIND_DB_RESOURCE, true);
            $plugin->getConfig()->set("maxmind-db-version", Main::MAXMIND_DB_RELEASE);
            LangManager::getInstance()?->initializeGeoIpReader();
        } else {
            $plugin->getLogger()->error("Failed to download MaxMind GeoLite2-Country database.");
        }
    }
}
