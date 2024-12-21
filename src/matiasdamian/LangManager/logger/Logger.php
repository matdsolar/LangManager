<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\logger;

use matiasdamian\LangManager\Main;
use pocketmine\utils\Config;

/**
 * Handles logging functionality for the LangManager plugin.
 */
class Logger{
	use LoggerTrait;
	
	private const LOG_SIZE_LIMIT = 10 * 1024 * 1024; // 10 MB
	
	private readonly Main $plugin;
	private readonly Config $logFile;
	
	/**
	 * Initializes the logger and sets up the log file.
	 *
	 * @param Main $plugin The main plugin instance.
	 */
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		$this->logFile = new Config(
			$plugin->getServer()->getDataPath() . "LangManager.log",
			Config::ENUM
		);
	}
	
	/**
	 * Logs a message with a specified log level.
	 *
	 * @param string $logLevel The log level (e.g., INFO, ERROR).
	 * @param string $logMessage The message to log.
	 */
	public function log(string $logLevel, string $logMessage): void{
		$this->rotateLogs();
		$this->plugin->getLogger()->log($logLevel, $logMessage);
		
		$formattedMessage = $this->formatLogMessage($logLevel, $logMessage);
		$this->logFile->set($formattedMessage, true);
	}
	
	/**
	 * Saves changes to the log file.
	 */
	public function save(): void{
		$this->logFile->save();
	}
	
	/**
	 * Formats the log message with a timestamp and log level.
	 *
	 * @param string $logLevel The log level (e.g., INFO, ERROR).
	 * @param string $logMessage The message to format.
	 * @return string The formatted log message.
	 */
	private function formatLogMessage(string $logLevel, string $logMessage): string{
		return sprintf(
			"[%s] [%s] %s",
			date("Y-m-d H:i:s"),
			strtoupper($logLevel),
			$logMessage
		);
	}
	
	/**
	 * Clears the log file if it exceeds the size limit.
	 */
	private function rotateLogs(): void{
		$logFilePath = $this->plugin->getServer()->getDataPath() . "LangManager.log";
		if(file_exists($logFilePath) && filesize($logFilePath) > self::LOG_SIZE_LIMIT){
			$this->logFile->setAll([]); // Reset log content
		}
	}
	
	/**
	 * Retrieves the plugin instance.
	 *
	 * @return Main The main plugin instance.
	 */
	private function getPlugin(): Main{
		return $this->plugin;
	}
	
}