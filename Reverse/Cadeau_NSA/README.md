# Writeup - Cadeau à la NSA

### Catégorie

Reverse

### Description

Pour montrer leur bonne foi à la NSA, les étudiants de l'ESNA ont décidé de lui envoyer un des flags du Midnight Flag spontanément, avant même que la NSA s'en empare par ses propres moyens. Pour cela, ils ont écrit le flag sur un morceau de papier qu'ils ont envoyé à Fort Meade, et pour garantir l'intégrité du flag, ils leur ont également envoyé un petit binaire qui vérifie si le flag reçu est bien le bon. Vous avez retrouvé le binaire en question caché sous une table, et vous vous demandez si le morceau de papier qui va avec est vraiment nécessaire pour trouver le flag...

### Auteur

SeulAParis

### Solution

Après une phase d'analyse initiale (avec objdump, radare2 ou n'importe quoi d'autre), on remarque à un endroit un appel à la fonction "strncmp". Nous avons également notion du fait que le flag est déchiffré pendant l'exécution du binaire (avec les strings, les symboles de noms de variables et de fonctions). A partir de là, nous nous rendons compte qu'il est inutile de s'embêter à déchiffrer le flag soit-même, puisque le binaire le fait pour nous. Il s'agit juste de réussir à lire sa mémoire pendant son exécution. Pour cela, nous pouvons soit faire appel à ltrace, soit utiliser gdb avec un breakpoint juste avant le strncmp:

```c
$ ltrace -s 48 ./nsa_flag_checker # l'argument s permet de voir le flag en entier, sinon il est tronqué
```

### Flag

MCTF{G3neR4l_K3n0b1...Y0u_Ar3_@_B0lD_0ne...}