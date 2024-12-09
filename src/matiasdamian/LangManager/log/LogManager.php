<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\log;

use matiasdamian\LangManager\LangManager;
use matiasdamian\LangManager\Main;
use pocketmine\utils\Config;

class LogManager{
	/** @var Config */
	private readonly Config $log;
	
	/**
	 * @param string $logFilePath
	 */
	public function __construct(Main $plugin){
		$this->log = new Config($plugin->getServer()->getDataPath() . "LangManager.log", Config::ENUM);
	}
	
	/**
	 * Logs language translation usage to the log file.
	 *
	 * @param int $type The type of log message.
	 * @param string $key The key for the language string.
	 * @param string $iso The ISO code for the language.
	 */
	public function logError(int $type, string $key, string $iso): void
	{
		$logMessage = "[" . date("Y-m-d H:i:s") . "] [ERROR] ";
		$logMessage .= match($type){
			LogMessages::TYPE_NOT_CASTABLE => "Parameter is not castable. Using ISO {$iso} and key {$key}.",
			LogMessages::NO_ISO_MESSAGE => "No ISO message available for ISO {$iso}. Key {$key}.",
			default => "Unknown error type {$type} for ISO {$iso} and key {$key}."
		};
		$this->log->set($logMessage, true);
	}
	
	public function save(): void{
		$this->log->save();
	}
	
}