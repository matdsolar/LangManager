<?php

namespace matiasdamian\LangManager\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;

use matiasdamian\LangManager\Main;
use matiasdamian\LangManager\LangManager;

/**
 * Class LangCommand
 *
 * Handles the /lang command, allowing players to set their preferred language
 * from a list of available languages.
 */
class LangCommand extends Command implements PluginOwned
{
	use PluginOwnedTrait;

	/**
	 * LangCommand constructor.
	 *
	 * @param Main $plugin
	 */
	public function __construct(Main $plugin)
	{
		parent::__construct("lang", "Set your preferred language", "/lang <language>", ["language"]);
		$this->setPermission("langmanager.lang");
		$this->owningPlugin = $plugin;
	}
	
	/**
	 * @return Plugin
	 */
	public function getOwningPlugin(): Plugin{
		return $this->owningPlugin;
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
		$languageList = array_change_key_case((array) $this->getOwningPlugin()->getConfig()->get("language-list"));
		
		foreach (LangManager::ALL_ISO_CODES as $language => $iso) {
			if(in_array(strtolower($iso), $languageList)){
				$languages[] = LangManager::translate("language_list", $sender, $language, $iso);
			}
		}
		$languages = implode("\n", $languages);

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