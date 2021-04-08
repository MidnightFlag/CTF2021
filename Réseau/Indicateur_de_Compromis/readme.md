# Indicateur de compromis

### Catégorie

Réseau

### Description

Vous avez récupéré un PC particulièrement vérolé...<br/> 
Le groupe TA505 est particulièrement actif en ce moment, vous pouvez vous rapprocher des autorités compétentes pour en savoir plus

Format : MCTF{}

### Auteur 

ouanair

### Solution

On ouvre la capture Wireshark, sur laquelle de multiples flux TCP et DUP sont présents <br/>

Dans l'onglet Statistiques > Endpoints, on remarque des flux vers de multiples hôtes avec peu de trafic : 

![](https://i.imgur.com/97Uh802.png)

<br/>

En filtrant sur un des endpoints, on affiche les trames UDP sortantes. La dernière trame contient une payload chiffrée. Pour connaitre le chiffrement (si pas reconnu à l'oeil nu), on utilise la fonction Magic de Cyberchef : 

![](https://i.imgur.com/kNXtqEe.png)

<br/>

On trouve bien le format du flag, mais avec un texte troll. Pour repérer la bonne trame, il faut aller sur le site de l'ANSSI et trouver les IOC du groupe TA505 (cf l'énoncé du challenge) : https://www.cert.ssi.gouv.fr/ioc/CERTFR-2021-IOC-001/

La première adresse IP (135.181.97.81) est bien présente dans notre fichier, déchiffrer sa payload nous donne le flag.

### Flag

MCTF{IOC_R_fun}
