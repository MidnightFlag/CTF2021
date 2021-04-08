# Do you know ARP ?

### Catégorie

Réseau

### Description

Cette capture réseau est vide à moins que ... ?

Format : MCTF{}

### Auteur 

Error404

### Solution

Il faut ouvrir le fichier de capture réseau. A première vue, il y a seulement des trames ARP avec des adresses MAC identiques. 

En observant de plus près, le dernier octet de chaque Adresse MAC destination change. Cette adresse MAC est présente dans la payload ARP seulement sur certaines trames : 

![](https://i.imgur.com/5hZh9Xk.png)

En récupérant toutes les données, on utilise une correspondance hexa => ascii et on flag :)

### Flag

MCTF{M@c_P0w3r}
