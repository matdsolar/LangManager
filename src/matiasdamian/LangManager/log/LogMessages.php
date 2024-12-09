<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\log;

interface LogMessages{
	
	
	// Parameter is not castable
	public const PARAMETER_NOT_CASTABLE = 0;
	
	// No ISO message available
	public const NO_ISO_MESSAGE = -1;
	
	// Fallback to default language
	public const FALLBACK_TO_DEFAULT_LANGUAGE = -2;
	
	// Unsupported ISO code
	public const UNSUPPORTED_ISO_CODE = -3;
	
}