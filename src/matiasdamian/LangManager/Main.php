<?php

namespace matiasdamian\LangManager;

use pocketmine\plugin\PluginBase;

use matiasdamian\LangManager\command\LangCommand;

/**
 * Class Main
 *
 * This class serves as the main plugin class for the LangManager plugin.
 */
class Main extends PluginBase
{

	public const MAXMIND_DB_RESOURCE = "GeoLite2-Country.mmdb";
	public const MAXMIND_DB_RELEASE = "2024.11.10";
	public const MAXMIND_DB_RESOURCE_URL = "https://github.com/matiasdamiandelsolar/GeoLite.mmdb/releases/download/2024.11.10/GeoLite2-Country.mmdb";

	/**
	 * @var Main|null $instance
	 */
	private static ?Main $instance = null;

	/**
	 * Gets the singleton instance of the Main class.
	 *
	 * @return Main|null The current instance of Main, or null if not set.
	 */
	public static function getInstance(): ?self
	{
		return self::$instance;
	}
	
	public function onLoad() : void{
		self::$instance = $this;
		new LangManager($this);
	}

	/**
	 * @return void
	 */
	public function onEnable(): void
	{

		$this->getServer()->getCommandMap()->register("langmanager", new LangCommand($this));
		$this->getLogger()->info("LangManager enabled.");
	}

	/**
	 * @return void
	 */
	public function onDisable(): void
	{
		LangManager::close();
		$this->getLogger()->info("LangManager disabled.");
	}
}