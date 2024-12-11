<?php

declare(strict_types=1);

namespace matiasdamian\LangManager\log;

interface LogMessages{
	public const PARAMETER_NOT_CASTABLE = 0;
	
	public const NO_ISO_MESSAGE = -1;
	
	public const FALLBACK_TO_DEFAULT_LANGUAGE = -2;
	
	public const UNSUPPORTED_ISO_CODE = -3;
	
}