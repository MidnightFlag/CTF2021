# Titre du challenge

Basic Exfiltration

### Catégorie

Forensic (Difficulté : Facile)

### Description

Un hacker vous envoie une capture réseau du traffic de son PC.<br/>
Il pense que vous ne trouverez rien d'intéressant dessus. Pouvez-vous lui prouver le contraire ?

Format : MCTF{}

### Auteur 

Kazuno

### Solution

Lorsque l'on regarde le traffic de la capture Wireshark, on remarque des trames HTTP.

On applique alors un filtre pour ne voir que le traffic HTTP.

On remarque alors qu'une image britney.jpg a été récupéré par le hacker.
On récupère via Fichier -> Exporter Objets --> HTTP --> enregister (en séléctionnant l'image britney.jpg)

On l'ouvre et le flag est affiché !

### Flag
 
MCTF{Br1tn3Y_Sp3aRs_F4n}
