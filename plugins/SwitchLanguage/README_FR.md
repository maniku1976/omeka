# Switch Language Omeka Plugin
[English version available](README.md)

Cette extension permet aux visiteurs de choisir la langue d'affichage du site. L'administrateur peut configurer la langue par défaut et la liste des langues disponibles.
## Pré-requis

Aucun.

## Installation
1. Télécharger l'extension Switch Language depuis le dépôt GitLab : [Switch Language GitLab Repository] et dézipper le fichier
 ```wget https://gitlab.com/TIME_LAS/Omeka_Plugin_SwitchLang/repository/archive.zip?ref=master -O Omeka_SwitchLanguage.zip```
 ```unzip Omeka_SwitchLanguage.zip #créé un dossier dont le nom ressemble à "Omeka_Plugin_SwitchLang-master-f20a8123c0692b0476085c2c3874fe554a7e7b64"  ```

[Switch Language GitLab Repository]: https://gitlab.com/TIME_LAS/Omeka_Plugin_SwitchLang/

2. Téléverser le dossier dézippé dans le dossier des plugins sur le serveur où Omeka est installé. Le nom du dossier du plugin doit être "SwitchLanguage". Voir la page [Installing a Plugin] (anglais) pour plus de détails.
 ```mv Omeka_Plugin_SwitchLang-master-XXX $OMEKA_PATH/plugins/SwitchLanguage```
[Installing a Plugin]: http://omeka.org/codex/Installing_a_Plugin

3. Aller sur la page de gestion des extensions de votre Omeka et cliquer sur le bouton vert "Installer" de l'extension « Switch Language ».

***Note.*** Il est aussi possible de télécharger l'extension en passant par git :

 ```git clone https://gitlab.com/TIME_LAS/Omeka_Plugin_SwitchLang.git```
 ```mv Omeka_Plugin_SwitchLang $OMEKA_PATH/plugins/SwitchLanguage```

## Configurer l'extension

L'extension Switch Language permet de configurer les options suivantes :
* Choisir la langue par défaut : il s'agira à la fois de la langue par défaut de l'interface publique, à la fois de la langue de l'interface d'administration.

* Choisir le type d'affichage :
 * Drop-down menu, links, or banners (flags) 
 * Afficher le nom de la langue name, le code de la langue ou, pour les drapeaux, les drapeaux seuls

* Il est possible d'utiliser des drapeaux personnalisés. Dans ce cas, déposer les images dans un sous-dossiers du thème courant et spécifier le nom du sous-dossier dans l'option « Theme subdirectory for flags (optionnal) »
 * Les noms de fichier doivent être de la forme : "flag-$LANGCODE.png" (par exemple, "flag-fr.png")
 * Les images doivent être des PNG et seront affichées avec une hauteur et une largeur de 25px
 * Si il n'y a pas de fichier correspond au code d'une langue dans le sous-dossier du thème, le drapeau par défaut fourni dans l'extension sera utilisé
 * Si aucun nom de sous-dossier n'est spécifié dans l'option, des drapeaux personnalisés seront recherchés dans le sous-dossier "img/" du thème courant
 * Le nom du sous-dossier doit finir par un slash "/" (par exemple, "custom-flag/")

* Choisir l'ensemble des langues qui seront disponibles dans l'interface publique
 * La liste proposée ne contient que les langues qui disposent d'un fichier de traduction dans le coeur d'Omeka, c'est-à-dire dans le dossier $OMEKA/application/languages/.