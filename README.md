# LangManager
![](https://github.com/matiasdamiandelsolar/LangManager/blob/main/icon.png)
LangManager is a powerful plugin that adds multilingual support to your Minecraft server, enabling seamless language management and translation for players. With this plugin, server owners can easily provide a personalized experience by allowing players to select their preferred language.

## Key Features

### Automatic Language Detection
The plugin automatically detects the user’s language and localizes the server based on the player’s location. Players always have the option to choose another language using the command /setlang

### Language Switching
Players can effortlessly switch between available languages using /setlang, allowing them to enjoy the game in their preferred language.
### Centralized Message Management
With LangManager, managing in-game messages, greetings, command responses, and error messages becomes easy. All messages are stored in easily manageable language files, allowing for straightforward translations tailored to the server owner’s preferences.

## Using LangManager as a user
The language files are stored in lang/ within your server folder. Make sure the server is turned off before editing any language files.

Language files supported:

| Language         | File   |                                       
|------------------|--------|
| English          | en.yml |
| Spanish          | es.yml |
 | Hindi           | hi.yml |
| Portuguese        | pt.yml |
| Chinese            | zh.yml |
 | Russian            | ru.yml |
| French            | fr.yml |
| German            | de.yml |
| Arabic            | ar.yml |
| Japanese           | ja.yml |
 | Bengali           | bn.yml |
 | Indonesian        | id.yml |
 | Korean            | ko.yml |
  | Turkish          | tr.yml |
  | Vietnamese        | vi.yml |
  | Polish             | pl.yml |
   | Thai               | th.yml |
  | Italian              | it.yml |
   | Persian             | fa.yml  |
 | Swedish               | sv.yml  |

To add or remove a language to the language list in /lang, simply modify the `config.yml` file.
```
language-list:
- en
- es
```
## Using LangManager as a developer
The plugin is equipped with built-in functions to send messages directly to players and translate strings, eliminating the need for hardcoded messages in your code.
This section will guide you on how to use the following methods:
- `LangManager::addKey()`
- `LangManager::send()`
- `LangManager::translate()`

First, make sure you import the LangManager class in your plugin.
```php
use matiasdamian\LangManager\LangManager;
```

### Adding a new language key with `LangManager::addKey()`
If you are a plugin developer and want to use LangManager, it is very easy to do so.

**Syntax:**
```php
LangManager::addKey(string $key, string $message) : bool;
```

Make sure you add LangManager as a dependency in your plugin.yml:

```
depend: [LangManager]
```

**Paramaters:**
- string $key: The key you want to add in the language file.
- string $message: The default message for the key you want to add (in English)

To avoid conflicts with other plugins, it's recommended to add a prefix to your key. For example, use a prefix like `MyPlugin-`, so your key might look like `MyPlugin-key`. This ensures that the key is unique across all plugins.

### Sending Messages with `LangManager::send()`

This method is designed to send messages to players in their preferred language.

**Syntax:**

```php
LangManager::send(string $messageKey, Player $player, ...$params);
```

**Parameters**
- string $messageKey: The key corresponding to the message you want to send (defined in your language files).
- Player $player: The player object to whom the message will be sent.
- - ...$params: Optional parameters for message formatting.

**Example Usage**
```php
// Assuming you have a Player object $player
$messageKey = "welcome_message"; // The message key from your language file

LangManager::send($messageKey, $player);
```
In this example, if the player’s language is set to English, they will receive the message defined by the `welcome_message` key in the `en.yml` file.

### Translating Messages with `LangManager::translate()`

This method is useful for translating strings that are not directly sent to the player, such as pop-ups.

**Syntax:**
```php
LangManager::translate(string $messageKey, Player $player, ...$params);
```

**Parameters:**
- string $messageKey: The key corresponding to the message you want to translate.
- Player $player: The player object to whom the translated message is intended.
- ...$params: Optional parameters for dynamic content within the translated message.

**Example Usage**
```php
// Assuming you have a Player object $player
$messageKey = "language_choose"; // The message key from your language file

// Sending a translated message as a popup or embed
$translatedMessage = LangManager::translate($messageKey, $player);
$player->sendMessage($translatedMessage); // Sending the translated message to the player
```
In this example, the player will receive the message defined by the `language_choose` key in the `en.yml` file.

## Using parameters in translations

When using the LangManager plugin, you can enhance your messages by utilizing parameters in your translation strings. Each parameter is denoted by an indexed placeholder such as `{%0}`, `{%1}`, and so on, which allows you to pass dynamic data into your messages. The number corresponds to the order in which you provide the parameters in the `LangManager::translate()` method.

**Example of Parameter Usage**

For instance, if you have a message in your language file like:
```
welcome_message = "Welcome, {%0}! You are currently at {X}, {Y}, {Z}."
```

You can send this message with parameters by using:
```php
$playerName = $player->getName();
LangManager::send("welcome_message", $player, $playerName);
```
This would result in a message like:
> "Welcome, PlayerName! You are currently at X, Y, Z."

You can pass as much parameters as needed.

### Available Server and Player Variables

In addition to using parameters, the plugin provides several server and player variables that you can utilize in your messages.

| Variable                     | Description                                  | Example Output                                                                                                                                                  |
|------------------------------|----------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Server Vars**              |                                              |                                                                                                                                                                 |
| `{ONLINE}`                   | The number of players currently online       | `5`                                                                                                                                                             |
| `{MAX}`                      | The maximum number of players allowed        | `20`                                                                                                                                                            |
| `{AVERAGE_TPS}`              | The average ticks per second                 | `19.8`                                                                                                                                                          |
| **Player Vars**              |                                              |                                                                                                                                                                 |
| `{X}`                        | Player's current X coordinate                | `100`                                                                                                                                                           |
| `{Y}`                        | Player's current Y coordinate                | `64`                                                                                                                                                            |
| `{Z}`                        | Player's current Z coordinate                | `200`                                                                                                                                                           |
| `{WORLD}`                    | The name of the world the player is in       | `survival`                                                                                                                                                      |
| `{LEVEL}`                    | The level name of the player's current world | `survival`                                                                                                                                                      |
| `{HEALTH}`                   | The player's current health                  | `20`                                                                                                                                                            |
| `{MAX_HEALTH}`               | The player's maximum health                  | `20`                                                                                                                                                            |
| `{PING}`                     | The player's ping to the server              | `50`                                                                                                                                                            |
| `{NAME}`                     | The player's username                        | `PlayerName`                                                                                                                                                    |
| `{DISPLAY_NAME}`             | The player's display name                    | `PlayerName`                                                                                                                                                    |
| **Formatting Tags**          |
| `<rainbow>Message≤/rainbow>` | Wrap a message in these tags to rainbowize it |                                                                                                                                                                 |
| `&0` to `&f`                 | Color codes for text formatting               |

**Example of Using Server and Player Variables**

Here’s how you can use server and player variables in a message:
```php
LangManager::send("welcome_message", $player);
```
If your message in the `.ini` file is
```
welcome_message = "There are currently {ONLINE} players online."
```
The output would be:
```
"There are currently 5 players online."
```

## Licensing information
This project is licensed under LGPL-3.0. Please see the LICENSE file for details.