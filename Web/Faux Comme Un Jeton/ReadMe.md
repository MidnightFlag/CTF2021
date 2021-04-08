Faux comme un jeton
===================

### <span id="anchor"></span>Catégorie

Web

### <span id="anchor-1"></span>Description

Un jeune codeur débutant vient de commencer à coder, il a implémenté un
processus d’authentification afin de segmenter les droits utilisateurs.
Mais il débute il ne connait pas encore les risques de son code.
Vous devez trouver la vulnérabilité de son application.

Format : MCTF{}

### <span id="anchor-2"></span>Auteur

Huriken

### <span id="anchor-3"></span>Solution

Quand on arrive sur ce challenge, nous avons les identifiants et les mot
de passes de deux utilisateurs différents.

En appuyant sur F12 nous pouvons voir dans l’onglet stockage qu’il
existe une variable token

Nous effectuons la même chose avec le second utilisateur et nous
récupérons aussi le JWT.

On utilise <https://jwt.io/> pour voir ce qu’il y a dans le token.
![alt](images/jwtio.png)
</br>

Les JWT utilisent comme algorithme du RS256.

Ils ont en data aussi les variables user, exp, isAdmin.

À partir de deux jetons RS256 nous pouvons récupérer la clé publique.

Je vais utiliser JWT key Recovery afin de retrouver la clé publique RSA
des jetons.

<https://github.com/FlorianPicca/JWT-Key-Recovery>

Maintenant que nous avons réussi à récupérer la clé public RSA, nous
allons réaliser la vulnérabilités ou il est possible de changer le
header, passant de RS256 à HS256.\
Pour ce faire, il est possible de signer notre token avec la clé
publique obtenue.

***PS = il est important d’utiliser la version pyJWT 0.4.3 afin de pouvoir
signer avec la clé publique.***

On signe notre JWT avec la clé publique obtenu et on change le isAdmin=0
en isAdmin=1.

On envoie la requête POST avec le token modifié :

curl -X POST -b
'token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwiaXNBZG1pbiI6MX0.SaXCQM13Lys7LH0OOG1PmRg9DVVjvISzz0EpKEnV4LE'
<http://127.0.0.1:5000/admin>

Et le flag est là, MCTF{r54W17H7W070K3N}.
