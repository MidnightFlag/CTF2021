Faux comme un jeton
===================

### <span id="anchor"></span>Catégorie

Web

### <span id="anchor-1"></span>Description

Un jeune développeur débutant vient de commencer à coder un site web, il a implémenté un
processus d’authentification afin de segmenter les droits utilisateurs.
Mais il débute il ne connait pas encore les risques de son code.

Format : MCTF{}

### <span id="anchor-2"></span>Auteur

Huriken

### <span id="anchor-3"></span>Solution

Quand on arrive sur ce challenge, nous avons les identifiants et les mot
de passes de deux utilisateurs différents.


![alt](images/login.png)
</br>

En appuyant sur F12 nous pouvons voir dans l’onglet stockage qu’il
existe une variable token

![alt](images/User1.png)
</br>

Nous effectuons la même chose avec le second utilisateur et nous
récupérons aussi le JWT.

![alt](images/user2.png)
</br>

On utilise <https://jwt.io/> pour voir ce qu’il y a dans le token.

Les JWT utilisent comme algorithme du RS256.

Ils ont en data aussi les variables user, exp, isAdmin.

![alt](images/jwtio.png)
</br>


À partir de deux jetons RS256 nous pouvons récupérer la clé publique.

Je vais utiliser JWT key Recovery afin de retrouver la clé publique RSA
des jetons.

<https://github.com/FlorianPicca/JWT-Key-Recovery>

![alt](images/jwtkeyrecovery.png)
</br>

Maintenant que nous avons réussi à récupérer la clé public RSA, nous allons réaliser la vulnérabilité de la confusion des clés HS/RSA où il est possible de changer le header, passant de RS256 à HS256. Pour ce faire, nous signons notre token avec la clé publique obtenue.

![alt](images/ScriptVulnJWT.png)
</br>

***PS = il est important d’utiliser la version pyJWT 0.4.3 afin de pouvoir
signer avec la clé publique.***

On signe notre JWT avec la clé publique obtenu et on change le isAdmin=0
en isAdmin=1.

On envoie la requête POST avec le token modifié :

![alt](images/flag.png)
</br>

curl -X POST -b
'token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwiaXNBZG1pbiI6MX0.SaXCQM13Lys7LH0OOG1PmRg9DVVjvISzz0EpKEnV4LE'
<http://127.0.0.1:5000/admin>

Et le flag est là, MCTF{r54W17H7W070K3N}.

### <span id="anchor-4"></span>Flag
MCTF{r54W17H7W070K3N}
