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
	 *                      This is typically a constant from the `LogMessages` class (e.g., `LogMessages::PARAMETER_NOT_CASTABLE`).
	 * @param array $context Additional context for the message, typically containing details such as ISO code and translation key.
	 *                       Example: `["en", "language-key"]` for an ISO code and a translation key.
	 * @return void
	 */
	public function log(int $message, array $context = []): void{
		[$logLevel, $logMessage] = $this->getLogDetails($message, $context);
		
		// Log the message with the appropriate level
		$this->plugin->getLogger()->log($logLevel, $logMessage);
		
		// Prepare and format the log message
		$formattedMessage = $this->formatLogMessage($logLevel, $logMessage);
		
		// Save the message to the log file
		$this->log->set($formattedMessage, true);
	}
	
	/**
	 * Returns the log level and message for the provided log code.
	 *
	 * @param int $message The log message code.
	 * @param array $context The context for the message.
	 * @return array An array containing the log level and log message.
	 */
	private function getLogDetails(int $message, array $context): array{
		return match ($message){
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
	 * Saves the logger
	 *
	 * @return void
	 */
	public function save(): void{
		$this->log->save();
	}
}