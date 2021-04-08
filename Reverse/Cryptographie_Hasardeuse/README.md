# Writeup - cryptographie hazardeuse

### Catégorie

Reverse

### Description

Il vous est parvenu que les étudiants de l'ESNA font circuler les mots de passe des machines partagées dans un gestionnaire de mots de passe customisé. Il se présente sous la forme d'un exécutable dans lequel les mots de passe sont camouflés, ce qui le rend très portable et facile à échanger. Il est de notoriété publique que la sécurité des mots de passe contenus à l'intérieur de l'exécutable est très faible, mais vous êtes curieux de savoir s'il est possible d'aller plus loin et de compromettre le mot de passe racine du gestionnaire de mots de passe en lui-même !

### Auteur

SeulAParis

### Solution

Nous avons un binaire qui nous demande un mot de passe, et qui prétend déchiffrer du contenu si on le lui donne. Si on veut jouer les malins, on pourrait tenter de voir s'il est possible de déchiffrer le contenu en question sans le mot de passe en regardant la fonction unlock_content, avant de se rendre compte qu'il n'y a même pas besoin de le déchiffrer : il est hardcodé en clair dans le binaire. Mais il ne contient pas le flag.

Pour ça, il va falloir attaquer la fonction de vérification du mot de passe : check_password.

Cette fonction démarre par une boucle qui modifie chaque caractère du mot de passe qu'on a entré.

Ensuite, ce mot de passe "chiffré" est comparé à une chaine hardcodée dans le binaire. Si le mot de passe chiffré correspond à cette chaine, nous avons gagné.

Le challenge est donc centré sur les opérations de "chiffrement" du mot de passe. Dans cutter (après décompilation ghidra), ce qui y correspond est le bloc de code suivant :

```c
var_15h._1_4_ = 0;
while ((int32_t)var_15h._1_4_ < 0x30) {
    uVar1 = *(uint8_t *)((int64_t)arg1 + (int64_t)(int32_t)var_15h._1_4_);
    uVar2 = add((uint64_t)*(uint8_t *)((int64_t)arg1 + (int64_t)(int32_t)var_15h._1_4_), 
                (uint64_t)(var_15h._1_4_ & 0xff));
    uVar2 = sub(0x69, (uint64_t)uVar2);
    uVar2 = multiply((uint64_t)uVar2, 0x42);
    uVar3 = divide((uint64_t)uVar2, (uint64_t)uVar1);
    *(undefined *)((int64_t)(int32_t)var_15h._1_4_ + (int64_t)arg1) = uVar3;
    var_15h._1_4_ = var_15h._1_4_ + 1;
}
```

Si on le nettoie un peu (en renommant "var\_15h.\_1\_4\_" à "i", en virant tous les casts inutiles, ...) :

```c
for(int i = 0 ; i < 0x30 ; i++) {
    uVar1 = *(char*)(arg1 + i);
    uVar2 = add(*(char*)(arg1 + i), (i & 0xff));
    uVar2 = sub(0x69, uVar2);
    uVar2 = multiply(uVar2, 0x42);
    uVar3 = divide(uVar2, uVar1);
    *(undefined *)(i + arg1) = uVar3;
}
```

Et enfin, si on remplace "arg1" par "password", les expressions \*(char\*)(password + i) par password[i], et qu'on retire toutes les variables intermédiaires :

```c
for(int i = 0 ; i < 48 ; i++) {
    password[i] = divide(multiply(sub(0x69, add(password[i], i)), 0x42), password[i]);
 }
 ```
 
Une approche tout à fait valable au départ serait de faire confiance aux noms des fonctions : divide divise, multiply multiplie, add additionne et sub soustrait. On pourrait donc coder un premier solver qui inverse ces opérations, avant de commencer à se demander pourquoi le développeur a voulu écrire des fonctions pour des opérations aussi génériques que des additions, puis de constater que notre solver, même s'il est parfaitement bien codé, nous crache n'importe quoi.

C'est à ce moment là qu'on se penche sur le code des fonctions add, sub, multiply et divide (encore dans cutter, et rapidement nettoyé pour virer les variables inutiles et les types trop réfléchis) :

```c
char divide(int arg1, int arg2) {
    return (char)arg1 ^ 0x7f;
}
int32_t multiply(int arg1, int arg2) {
    return (char)arg2 + (char)arg1;
}
char sub(int arg1, int arg2) {
    return (char)arg1 ^ (char)arg2;
}
uint32_t add(int arg1, int arg2){
    uint8_t = (char)arg1 + (char)arg2;
    return (uint32_t)uVar1 << 4 ^ (uint32_t)(uVar1 >> 4);
}
```

Quelle honte ! Le développeur nous a menti !

A partir de là, il suffit juste de réécrire le solver en effectuant bien les bonnes opérations, dans l'ordre inverse à celui où elles sont faites dans le programme d'origine.

Voici pour terminer le code du script python qui permet de retrouver le flag :

```py
def revert(char, i):
        ret = char ^ 0x7f
        ret = (ret - 0x42) % 0x100
        ret ^= 0x69

        ret = ((ret >> 4) & 0xf) ^ ((ret << 4) & 0xf0)
        ret -= i

        return chr(ret)

target = b"\x80\x10\x31\x40\x9f\x40\x33\x2e\x2f\x43\xb1\x6e\xce\x9f\xde\xe3\x0e\xcf\x40\x5f\x20\x0f\x3e\xdd\xfe\x5f\x70\x2c\xc1\x40\x7f\xdf\x5c\x11\x6d\xfc\xfe\x2d\x41\x3c\x0f\xfa\x61\x4d\xdf\x7a\xb2\xa2"
result = ""

for i in range(48):
        result += revert(target[i], i)

print(result)
```

### Flag

MCTF{D0_n0T_TrU$T_7h3_SyMb0l5,_Th3y_Ar3_Ly1nG}