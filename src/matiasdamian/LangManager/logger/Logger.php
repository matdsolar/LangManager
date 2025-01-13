<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\logger;

use matiasdamian\LangManager\Main;
use pocketmine\utils\Config;

/**
 * Logger class responsible for managing logging functionality within the LangManager plugin.
 */
class Logger{
	use LoggerTrait;
	
	private const LOG_SIZE_LIMIT = 10 * 1024 * 1024; // 10 MB
	
	private readonly Main $plugin;
	private readonly Config $logFile;
	
	/**
	 * Logger constructor.
	 *
	 * @param Main $plugin The main plugin instance.
	 */
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		$this->logFile = new Config($this->getLogFilePath(), Config::ENUM);
	}
	
	/**
	 * Logs a message with the given log level.
	 *
	 * @param string $logLevel The log level (e.g., EMERGENCY, ALERT).
	 * @param string $logMessage The message to log.
	 * @return void
	 */
	protected function log(string $logLevel, string $logMessage): void{
		$logFilePath = $this->getLogFilePath();
		
		if(file_exists($logFilePath) && filesize($logFilePath) > self::LOG_SIZE_LIMIT){
			rename($logFilePath, $logFilePath . '_' . date("Y-m-d_H-i-s");
			$this->logFile->setAll([]);
		}
		
		$this->plugin->getLogger()->log($logLevel, $logMessage);
		$formattedMessage = $this->formatLogMessage($logLevel, $logMessage);
		$this->logFile->set(uniqid(), $formattedMessage);
	}
	
	/**
	 * Formats the log message with a timestamp and log level.
	 *
	 * @param string $logLevel The log level
	 * @param string $logMessage The log message.
	 * @return string The formatted log message.
	 */
	private function formatLogMessage(string $logLevel, string $logMessage): string{
		return sprintf("[%s] [%s] %s", date("Y-m-d H:i:s"), strtoupper($logLevel), $logMessage);
	}
	
	/**
	 * Gets the full path to the log file.
	 *
	 * @return string The log file path.
	 */
	private function getLogFilePath(): string{
		return $this->plugin->getServer()->getDataPath() . "LangManager.log";
	}
	
	
	/**
	 * Saves the log file to persist changes.
	 *
	 * @return void
	 */
	public function save(): void{
		$this->logFile->save();
	}
	
}