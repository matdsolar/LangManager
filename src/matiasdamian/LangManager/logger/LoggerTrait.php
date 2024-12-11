<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\logger;

trait LoggerTrait{
	
	/**
	 * Logs an emergency level message.
	 *
	 * @param string $message The message to log
	 * @return void
	 */
	public function emergency(string $message): void{
		$this->log(\LogLevel::EMERGENCY, $message);
	}
	
	/**
	 * Logs an alert level message.
	 *
	 * @param string $message The message to log
	 * @return void
	 */
	public function alert(string $message): void{
		$this->log(\LogLevel::ALERT, $message);
	}
	
	/**
	 * Logs an error level message.
	 *
	 * @param string $message The message to log
	 * @return void
	 */
	public function critical(string $message): void{
		$this->log(\LogLevel::CRITICAL, $message);
	}
	
	/**
	 * Logs an error level message.
	 *
	 * @param string $message The message to log
	 * @return void
	 */
	public function error(string $message): void{
		$this->log(\LogLevel::ERROR, $message);
	}
	
	/**
	 * Logs a warning level message.
	 *
	 * @param string $message The message to log
	 * @return void
	 */
	public function warning(string $message): void{
		$this->log(\LogLevel::WARNING, $message);
	}
	
	/**
	 * Logs a notice level message.
	 *
	 * @param string $message The message to log
	 * @return void
	 */
	public function notice(string $message): void{
		$this->log(\LogLevel::NOTICE, $message);
	}
	
	
	/**
	 * Logs a debug level message.
	 *
	 * @param string $message The message to log
	 * @return void
	 */
	public function info(string $message): void{
		$this->log(\LogLevel::INFO, $message);
	}
	
	/**
	 * Logs a debug level message.
	 *
	 * @param string $message The message to log
	 * @return void
	 */
	public function debug(string $message): void{
		$this->log(\LogLevel::DEBUG, $message);
	}
	
}
