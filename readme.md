# Mettre en ligne le dossier en local:



Aller sur le dépot git : [GITHUB](https://github.com/Kazzouwi/QuaiAntiqueECF)

Créer un dossier pour pouvoir copier le code dedans, puis initialiser le dossier avec la commande : git init
Enfin copier le code avec : git clone lien-du-dépot


Lancer votre application de base de données local (ex: MampPro)

Une fois le code copier, rendez-vous dans le dossier .env pour paramettrer la base de données du ficher ex :
DATABASE_URL="mysql://id-databse:mdp-database@127.0.0.1:8889/database-name?serverVersion=5.7"

Ensuite executer la commande : php bin/console doctrine:database:create

Ensuite aller dans le dossier migrations, puis cliquer sur la dernières migration et modifié les infos qui vous seront attribuées pour créer votre compte admin :
$this->addSql('INSERT INTO `user` (`id`, `email`, `roles`, `password`, `guests`) VALUES (NULL, \'Votre@adresse.mail\', \'[\"ROLE_ADMIN\"]\', \'mot-de-passe-hasher\', 1);');

Pour hasher le mdp, utiliser la commande:

ensuite utiliser la commande : php bin/console d:m:m pour migrer les informations vers la base de données.

effectuer un symfony server:start.

Voila vous pouvez explorer le site en local !

