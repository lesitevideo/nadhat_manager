0- Connectez le raspberry pi à votre box internet (wifi ou rj45)

1- Connectez-vous au raspberry pi en ssh (vous pouvez connaître son adresse IP en allant sur le routeur de votre box)

2- Vous arrivez dans /home/pi, copiez-y l'appli :

> git clone git://github.com/lesitevideo/nadhat_manager 

3- Allez dans le dossier :

> cd nadhat_manager

4- Installez l'appli :

> npm install

5- Pour que l'appli se lance au démarrage du raspberry, editez le fichier /etc/rc.local

> sudo nano /etc/rc.local

6- Après les commentaires du début, ajoutez la ligne

> su pi -c '/usr/bin/node /home/pi/nadhat_manager/index.js < /dev/null &'

7- Enfin, faites un chmod pour pouvoir lire les fichiers de gammu-smsd

> sudo su
> sudo chmod a+r /var/spool/gammu/*
> exit

Cette dernière opération peut sembler un problème de sécurité, mais dans la mesure où le NadHat est sur votre réseau local, il n'y a pas de risques !
