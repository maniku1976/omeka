# Switch Language Omeka Plugin
[French version available](README_FR.md)

This plugin allow users to choose the website language. Admin can configure the public languages available and the default website language.

## Requirements

Nothing.

## Installation
1. Download the Switch Language Plugin from its GitLab Repository: [Switch Language GitLab Repository] and unzip it
 ```wget https://gitlab.com/TIME_LAS/Omeka_Plugin_SwitchLang/repository/archive.zip?ref=master -O Omeka_SwitchLanguage.zip```
 ```unzip Omeka_SwitchLanguage.zip #create a directory like "Omeka_Plugin_SwitchLang-master-f20a8123c0692b0476085c2c3874fe554a7e7b64"  ```

[Switch Language GitLab Repository]: https://gitlab.com/TIME_LAS/Omeka_Plugin_SwitchLang/

2. Upload the plugin to the plugins directory of your Omeka installation in a "SwitchLanguage" directory. See the [Installing a Plugin] page for details.
 ```mv Omeka_Plugin_SwitchLang-master-XXX $OMEKA_PATH/plugins/SwitchLanguage```
[Installing a Plugin]: http://omeka.org/codex/Installing_a_Plugin

3. Once it's uploaded and unzipped in the `plugins` directory, go to the plugins management interface and click on the green "Install" button in the listing for the Switch Language plugin.

***Note.*** You can also use git to download the plugin:

 ```git clone https://gitlab.com/TIME_LAS/Omeka_Plugin_SwitchLang.git```
 ```mv Omeka_Plugin_SwitchLang $OMEKA_PATH/plugins/SwitchLanguage```

## Configure the plugin

The Switch Language plugin lets you choose the following options:
* Choose the default language: this will be both the default public language and the admin interface language.

* Choose the display type:
 * Drop-down menu, links, or banners (flags) 
 * Displaying language name, language code, or flags only

* If you want to use customized flags, put files on a subdirectory of your theme and specify it as a plugin option
 * File names must be: "flag-$LANGCODE.png" (e.g. "flag-fr.png")
 * Images have to be PNG and will be display with height and width of 25px
 * If no flag is found in the theme, plugin flags will be used
 * If no subdirectory is specified, the plugin will look for an "img/" directory
 * Subdirectory must finish by "/" (e.g. "custom-flag/")

* Choose the language which will be available on the public interface
 * List only the language which have a translate file in your $OMEKA/application/languages/ directory