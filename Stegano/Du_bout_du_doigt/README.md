# Titre du challenge
Du bout du doigt

### Catégorie

Stéganographie (Difficulté : Difficile)

### Description

En 1984, un employé de l'entreprise IBM s'est mis à jouer avec leur dernier produit : le clavier M.
Pouvez-vous vérifier que la chaîne de caractères qu'il a composé ne contient pas de message caché ?

/!\ Le flag est en majuscule. /!\

Format : MCTF{}

### Auteur 

NGD

### Solution

Comme le laisse penser le titre du challenge, le toucher est important. 
Pour résoudre le challenge, il suffit de faire glisser son doigt sur les touches du clavier en suivant l'ordre des chiffres/caractères.

Exemple: 

1475963 = M 
https://i.imgur.com/wBBOhRT.png

De même pour chaque suite de chiffres/caractères entre '|'

Dans 1475963|9874123|789852|74178945|*/854520.|95275|874123698|7412369|7456963|741789653|987412345|1478963456|74178945|7412369|9874123|7415953|4852123|1475369|9874123656|9874123656|789656321|1475369|852789123|412369874|7412369|987456321|/*96+63.0

On a donc :

M = 1475963
C = 9874123
T = 789852
F = 74178945
{ = */854520.
Y = 95275
O = 874123698
U = 7412369
A = 1478963456
R = 741789653
E = 987412345
4 = 7456963
F = 74178945
U = 7412369
C = 9874123
K = 7415953
1 = 4852123
N = 1475369
G = 9874123656 
G = 9874123656
3 = 789656321
N = 1475369
I = 852789123
O = 412369874
U = 7412369
S = 987456321
} = /*96+63.0

### Flag
 
MCTF{YOUARE4FUCK1NGG3NIOUS}
