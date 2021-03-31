# Le Passbook

### Catégorie

Stegano

### Description

On vous a appporté une clé USB retrouvé sur le parking, elle contient l'image suivante.

Votre intuition vous dit que cette image renferme des secrets, percer-les !

### Auteur

A0d3n

### Solution

image MCTF.png --> contient le texte en base64 + image waf qui sert à rien

aHR0cHM6Ly93d3cuY3J5cHRvc2VjLm9yZy9kb2NzL0NvdXJzTWFzdGVyMjAxOC9Db3Vyc0N5YmVyU2VjdXJpdGVNYXN0ZXJfMjAxOF92My5wZGYKNCAxIDEgMTMgNSAxIDkwIDE2IDE=

https://www.cryptosec.org/docs/CoursMaster2018/CoursCyberSecuriteMaster_2018_v3.pdf
4 1 1_13 5 1_90 16 1

les chiffres corresponds à des pages, lignes et numéro du mot sur la ligne

Voilà, vous venez de trouver le flag !

### Flag

MCTF{Target_Cyberdélinquance_zéro}
