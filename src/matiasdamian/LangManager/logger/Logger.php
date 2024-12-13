<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\logger;

use matiasdamian\LangManager\Main;
use pocketmine\utils\Config;

/**
 * Logger class responsible for managing logging functionality within the LangManager plugin
 */
class Logger{
	use LoggerTrait;
	
	private const LOG_SIZE_LIMIT = 1024 * 1024 * 10; // 10 MB
	
	/** @var Main */
	private readonly Main $plugin;
	
	/** @var Config */
	private readonly Config $logFile;
	
	/**
	 * Logger constructor.
	 *
	 * @param Main $plugin The main plugin instance.
	 */
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		$this->logFile = new Config($plugin->getServer()->getDataPath() . "LangManager.log", Config::ENUM);
	}
	
	/**
	 * Gets the main plugin instance.
	 *
	 * @return Main The main plugin instance
	 */
	private function getPlugin() : Main{
		return $this->plugin;
	}
	
	/**
	 * Logs a message with the given log level.
	 *
	 * @param string $logLevel The log level (e.g., 'emergency', 'alert', etc.)
	 * @param string $logMessage The message to log
	 * @return void
	 */
	public function log(string $logLevel, string $logMessage): void{
		$this->rotateLogs();
		
		// Log the message with the appropriate level
		$this->plugin->getLogger()->log($logLevel, $logMessage);
		
		// Prepare and format the log message
		$formattedMessage = $this->formatLogMessage($logLevel, $logMessage);
		
		// Save the message to the log file
		$this->logFile->set($formattedMessage, true);
	}
	
	/**
	 * Formats the log message with the current timestamp and log level.
	 *
	 * @param string $logLevel The log level (e.g., INFO, WARNING, ERROR).
	 * @param string $logMessage The log message.
	 * @return string The formatted log message.
	 */
	private function formatLogMessage(string $logLevel, string $logMessage): string{
		$logLevel = strtoupper($logLevel);
		return sprintf("[%s] [%s] %s", date("Y-m-d H:i:s"), $logLevel, $logMessage);
	}
	
	/**
	 * Rotates the log file if it exceeds the size limit.
	 * @return void
	 */
	private function rotateLogs() : void{
		$logFilePath = $this->getPlugin()->getServer()->getDataPath() . "LangManager.log";
		if(filesize($logFilePath) > self::LOG_SIZE_LIMIT){
			$this->logFile->setAll([]);
		}
	}
	
	/**
	 * Saves the logger.
	 * @return void
	 */
	public function save(): void{
		$this->logFile->save();
	}
}