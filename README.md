Projet Zend Groupe 6 - CMS
=======================

Installation
------------

```bash
git clone https://github.com/gaelgf/projetZend
```

```bash
cd projetZend
```

```bash
composer install
```

Sur [localhost/phpmyadmin](localhost/phpmyadmin) => créer une bdd nommée projetzend

Aller dans cette bdd puis dans l'onglet sql et exécuter ce code :

```sql
    CREATE TABLE `user`
    (
        `user_id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username`      VARCHAR(255) DEFAULT NULL UNIQUE,
        `email`         VARCHAR(255) DEFAULT NULL UNIQUE,
        `display_name`  VARCHAR(50) DEFAULT NULL,
        `password`      VARCHAR(128) NOT NULL,
        `state`         SMALLINT UNSIGNED
    ) ENGINE=InnoDB CHARSET="utf8";
```

Insérer un utilisateur

Aller à l'adresse [http://localhost/projetZend/public/](Http://localhost/projetZend/public/)

ça devrait marcher