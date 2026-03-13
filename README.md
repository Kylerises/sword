# SwordClicker

## Installation

Pour installer les dépendances du projet faire les commandes suivantes dans le cmd

```cmd
composer update
```

Modifier le chemin dans le .htaccess

Racine du site mettre un **/** , mettre si dans un dossier **/nom_dossier/**

```
RewriteBase /
```

Faire la même chose dans le src/core/contants.php

```php
const PATH = "/";
```
