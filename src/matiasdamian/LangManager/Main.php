<?php

namespace matiasdamian\LangManager;

use pocketmine\plugin\PluginBase;

/**
 * Class Main
 *
 * This class serves as the main plugin class for the LangManager plugin.
 */
class Main extends PluginBase
{

	public const MAXMIND_DB_RESOURCE = "GeoLite2-Country.mmdb";

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

	/**
	 * @return void
	 */
	public function onEnable(): void
	{
		self::$instance = $this;
		$this->saveResource(self::MAXMIND_DB_RESOURCE, true);
		$this->saveResource("lang/en.ini", false);
		$this->saveResource("lang/es.ini", false);

		$this->getServer()->getCommandMap()->register("langmanager", new LangCommand($this));

		new LangManager($this);
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
