<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\log;

use matiasdamian\LangManager\Main;
use pocketmine\utils\Config;

class Logger implements \LogLevel{
	/** @var Main */
	private readonly Main $plugin;
	
	/** @var Config */
	private readonly Config $log;
	
	/**
	 * Constructor to initialize log configuration.
	 *
	 * @param Main $plugin The main plugin instance.
	 */
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		$this->log = new Config($plugin->getServer()->getDataPath() . "LangManager.log", Config::ENUM);
	}
	
	/**
	 * This method processes a log message using a message code, determines the log level (e.g., WARNING, INFO, ERROR),
	 * and logs the message with the given context. The message can provide useful details like the ISO code and translation key.
	 *
	 * @param int $message The log message code, which determines the log level and format of the message.
	 *                      This is typically a constant from the `Logger` class (e.g., `Logger::PARAMETER_NOT_CASTABLE`).
	 * @param array $context Additional context for the message, typically containing details such as ISO code and translation key.
	 *                       Example: `["en", "language-key"]` for an ISO code and a translation key.
	 * @return void
	 */
	public function log(int $message, array $context = []): void{
		[$logLevel, $logMessage] = match ($message) {
			LogMessages::PARAMETER_NOT_CASTABLE => [
				self::WARNING,
				"Parameter is not castable. Using ISO {$context[0]} and key {$context[1]}."
			],
			LogMessages::NO_ISO_MESSAGE => [
				self::WARNING,
				"No ISO message available for ISO {$context[0]}. Key {$context[1]}."
			],
			LogMessages::FALLBACK_TO_DEFAULT_LANGUAGE => [
				self::INFO,
				"Falling back to default language for ISO {$context[0]}. Key: {$context[1]}."
			],
			LogMessages::UNSUPPORTED_ISO_CODE => [
				self::WARNING,
				"Unsupported ISO code: {$context[0]}. Using default language."
			],
			
			default => [
				self::ERROR,
				"Unknown log message: {$message} with context: " . json_encode($context)
			]
		};
		
		$this->plugin->getLogger()->log($logLevel, $logMessage);
		$logLevel = strtoupper($logLevel);
		$formattedMessage = sprintf("[%s] [%s] %s", date("Y-m-d H:i:s"), $logLevel, $logMessage);
		
		$this->log->set($formattedMessage, true);
	}
	
	/**
	 * Saves the logger
	 *
	 * @return void
	 */
	public function save(): void{
		$this->log->save();
	}
}