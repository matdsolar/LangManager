<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\logger;

trait LoggerTrait{
	/**
	 * Logs a message with a specific log level.
	 *
	 * @param string $logLevel The log level (e.g., emergency, alert).
	 * @param string $message The message to log.
	 * @return void
	 */
	abstract protected function log(string $logLevel, string $message): void;
	
	public function emergency(string $message): void{
		$this->log(\LogLevel::EMERGENCY, $message);
	}
	
	public function alert(string $message): void{
		$this->log(\LogLevel::ALERT, $message);
	}
	
	public function critical(string $message): void{
		$this->log(\LogLevel::CRITICAL, $message);
	}
	
	public function error(string $message): void{
		$this->log(\LogLevel::ERROR, $message);
	}
	
	public function warning(string $message): void{
		$this->log(\LogLevel::WARNING, $message);
	}
	
	public function notice(string $message): void{
		$this->log(\LogLevel::NOTICE, $message);
	}
	
	public function info(string $message): void{
		$this->log(\LogLevel::INFO, $message);
	}
	
	public function debug(string $message): void{
		$this->log(\LogLevel::DEBUG, $message);
	}
}