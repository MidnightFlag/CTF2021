# Titre du challenge

Basic Exfiltration

### Catégorie

Forensic (Difficulté : Facile)

### Description

Un hacker vous envoie une capture réseau du traffic de son pc.<br/>
Il pense que vous ne trouverez rien d'intéressant dessus. Pouvez-vous lui prouver le contraire ?

Format : MCTF{}

### Auteur 

Kazuno

### Solution

Lorsque l'on regarde le traffic de la capture Wireshark, on remarque des trames HTTP.

On applique alors un filtre pour ne voir que le traffic HTTP.

On remarque alors qu'une image weapons.png a été récupéré par la victime.
On récupère via Fichier -> Exporter Objets --> HTTP --> enregister (en séléctionnant l'image weapons.png)

On l'ouvre et le flag est affiché !

### Flag
 
MCTF{W34p0ns_4r3_N0t_s3cUr3D}
