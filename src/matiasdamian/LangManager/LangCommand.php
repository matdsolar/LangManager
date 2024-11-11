<?php

namespace matiasdamian\LangManager;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

/**
 * Class LangCommand
 *
 * Handles the /lang command, allowing players to set their preferred language
 * from a list of available languages.
 */
class LangCommand extends Command
{

	public function __construct(Main $plugin)
	{
		parent::__construct("lang", "Set your preferred language", "/lang <language>", ["language"]);
		$this->setPermission("langmanager.lang");
	}

	/**
	 * Executes the /lang command.
	 *
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param array $args
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool
	{
		if (!($sender instanceof Player)) {
			$sender->sendMessage(LangManager::translate("error_no_permission"));
			return false;
		}

		$languages = [];
		foreach (LangManager::ALL_ISO_CODES as $language => $iso) {
			$languages[] = LangManager::translate("language_list", $sender, $language, $iso);
		}
		$languages = implode(", ", $languages);

		if (count($args) < 1) {
			$sender->sendMessage(LangManager::translate("language_choose", $sender) . "\n" . $languages);
			return false;
		}

		$langManager = LangManager::getInstance();

		$iso = strtolower($args[0]);
		if (!$langManager->isLanguageAvailable($iso)) {
			// Send error message for invalid language selection
			$sender->sendMessage(LangManager::translate("error_invalid_language", $sender));
			return false;
		}

		$language = $langManager->setPlayerLanguage($sender, $iso);
		// Send confirmation message when the language is set
		LangManager::send("language_set", $sender, $language);
		return true;
	}
}
