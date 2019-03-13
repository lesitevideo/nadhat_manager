**Pré-requis :**
- NadHat : https://www.amazon.fr/NadHAT-Carte-dextension-GPRS-Raspberry/dp/B0797YL1K5/ref=sr_1_3?m=A2O02H5QIV1HUA&s=merchant-items&ie=UTF8&qid=1552156579&sr=1-3
- Raspberry Pi Zero W
- distribution NadBian : https://blog.garatronic.fr/index.php/fr/actualites-en/47-distribution-nadbian-lite-fr

**Configurer le Raspberry Pi**

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


**Plugin Wordpress**

Installez le plugin wordpress nadhat_manager comme n'importe quel plugin, en le placant dans 'wp-content/plugins/'.
Ensuite, rendez-vous sur la page de configuration pour renseigner l'adresse IP et le PORT du Raspberry.
