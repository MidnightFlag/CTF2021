# Writeup - La bombe

### Catégorie

Reverse

### Auteur

SeulAParis

### Solution 

Le chall se compose d'un binaire pour lequel il faut réussir à désamorcer une bombe en trois étapes, pour éviter qu'elle explose. La bombe explose si un seul de nos inputs est faux, mais elle n'impose pas de limite de temps pour la résolution du chall.

Chaque phase correspond à une fonction qui vérifie un mot : si le mot est bon, on continue, sinon la bombe explose. Le mot est attendu sur l'entrée standard. 

## Phase 1

La phase 1 est triviale : elle vérifie que le mot correspond à sa valeur attendue par un simple "strcmp". On peut donc retrouver le mot attendu par simple lecture du code (dans cutter ou même dans objdump), puisqu'il est écrit en clair dans la section .rodata du binaire.

## Phase 2

La phase 2 commence par vérifier que le mot fait bien 5 caractères.

Ensuite, elle vérifie une série de 5 équations, qui doivent toutes être vraies si on veut passer à l'étape suivante.

Nous pouvons donc construire un système de 5 équations à 5 inconnues :

- a[1] = a[0] + 34
- a[2] = a[1] + 16
- a[3] = a[2] + 7
- a[4] = a[3] + 11
- a[2] = a[0] * 2 + 2

On pourrait les passer dans z3 mais ça se fait également très bien à la main. Nous voyons que 3 des équations (les première, deuxième et dernière) n'impliquent que 3 variables : ça nous fait 3 équations à 3 inconnues :

- a[1] = a[0] + 34
- a[2] = a[1] + 16
- a[2] = a[0] * 2 + 2


- a[1] = a[0] + 34
- a[2] = a[0] + 34 + 16
- a[0] + 34 + 16 = a[0] * 2 + 2


- a[1] = a[0] + 34
- a[2] = a[0] + 34 + 16
- a[0] = 34 + 16 - 2 = 48


- a[0] = 48 = '0'
- a[1] = 48 + 34 = 82 = 'R'
- a[2] = 48 + 34 + 16 = 98 = 'b'
- [...]

A partir de là, on retrouve les valeurs numériques attendues pour chaque caractère du mot, et en les convertissant en ASCII on retrouve le mot attendu.

## Phase 3

Tout d'abord, on voit que la fonction utilise un alphabet qui est dans .rodata et une sorte de chaine de caractères obfusquée (qu'on appellera "secret") qui est poussée sur la stack dans le code.

```c
char secret[] = "\x0a\x26\x0c\x03\x33\x37\x04\x31\x0c\x03";
```

Toute la section de code assembleur qui précède l'appel à la fonction readline ne sert qu'à charger l'alphabet sur la stack. Oui c'est beaucoup pour pas grand chose (même le décompilateur ghidra de cutter pond une horreur pour ce morceau).

Ensuite, la fonction vérifie que la longueur du mot est bien de 10 caractères.

Enfin, nous entrons dans une boucle qui effectue une vérification sur chaque caractère de notre mot. La vérification effectuée cherche à savoir si le caractère actuel (mot[i]) correspond bien au caractère de l'alphabet qui se trouve à l'index donné par secret[i]. Autrement dit :

```c
for(int i = 0 ; i < 10 ; i++) {
    if(mot[i] != alphabet[secret[i]]) {
        explode_bomb();
    }
}
```

Il ne nous reste plus qu'à reconstituer le mot à partir des index que l'on trouve dans la variable "secret" : le premier (0xa) est le 10ème caractère de l'alphabet ('A'), le deuxième (0x26) son 38ème caractère ('c'), et ainsi de suite.

### Flag

MCTF{s3as0n4l_0Rbit_AcC3pt4nC3}