# The hidden message

### Catégorie

Stegano

### Description

La NASA vient de recevoir les premières images de son nouveau rover marsien Perseverance<br/>

Depuis quelques heures, le Command Control aurait des problèmes pour envoyer les instructions au rover... Selon eux, le vent martien brouillerait les communications avec le rover.<br/>

En tant que fin connaisseur, vous sentez que quelque chose cloche, mais quoi...<br/>

Votre but est de trouver ce détail et de prévenir la NASA au plus vite.<br/>

Bonne chance citoyenne, citoyen ! <br/>

Format : MCTF{}

### Auteur

A0d3n

### Solution

1 – Un gif du rover Perseverance contenant une archive ZIP.
<br/>
2 – Dans l’archive, on trouve :
• Un fichier txt
• Une archive protéger par un mdp
<br/>
3 – Sur le fichier txt, on utilise un strings pour trouver le mdp de l’archive.
<br/>
4 – Dans l’archive, on trouve la vidéo qu’il faut ouvrir avec Audacity pour trouver le flag cacher dans le spectrogramme.
<br/>

Ouvrir le fichier au format mp4 dans Audacity<br/>

![alt](images/mainaudacity.png)
<br/><br/>

Puis, on sélectionne l'option "Spectrogramme" dans le menu déroulant de notre piste audio.

![alt](images/spectrogramme_option.png)
<br/><br/>

Enfin, on modifie la vitesse de lecture de notre piste audio au maximum.

![alt](images/modif_vitesse.png)
<br/><br/>

Voilà, vous venez de trouver le flag !

### Flag

MCTF{P3r53v3R4nc3_G0}
