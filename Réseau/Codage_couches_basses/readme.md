# Codage couches basses

### Catégorie

Réseau

### Description

Vous avez intercepté des échanges sur un réseau legacy Ethernet 10mbps.
Pourrez vous récupérer les données encodées ?

Format : mctf{}

### Auteur 

ouanair

### Solution

Le fichier texte fourni donne une chaine de caractères binaires. Deux indices dans le titre/intitulé : codage et Ethernet 10Mbps. Le codage utilisé sur cette technologie est le codage Manchester. La payload peut être lue à la main mais il existe un tool en ligne utile : 

https://www.dcode.fr/manchester-code

![](https://i.imgur.com/5FWzHlO.png)

Cela nous donne une chaine binaire, qu'il suffit de passer en ASCII : 

![](https://i.imgur.com/HWdyUVg.png)


### Flag

mctf{g0_m4nCh35t3R}