# Writeup - La grande évasation

### Catégorie

Reverse

### Description

Une alarme pilotée par un arduino a été cachée dans les faux plafonds de l'ESNA. Pour partir en pause plus tôt, vous avez pour projet de déclencher l'alarme à distance pour que les élèves soient évacuées de la classe. Vous avez réussi à prendre la main sur la machine qui pilote l'arduino, mais il vous manque un code secret pour activer l'alarme. Sans doute arriverez-vous à le retrouver en analysant le fichier .hex qui a été chargé sur l'arduino en question !

### Auteur

SeulAParis

### Solution

Tout le défi ici se trouve dans la recherche de l'outil et des commandes à utiliser pour reverse un fichier ihex arduino.
On constate en effet que les outils classiques tels que strings, objdump et tout ne sont pas d'une grande utilité à cause du format de ce fichier.
- Si on n'aime pas télécharger d'outils, on peut se renseigner sur le format de fichier ihex et se rendre compte que les données qui y sont présentes sont simplement encodées en hexa : si on cherche "MCTF" en hexa (4d435446) dans le fichier, on trouve l'endroit où se trouve le flag (grep -i 4d435446 challenge.hex) et on peut le reconstituer à partir de notre connaissance du format de fichier ihex.<br/>
- Si on a avr-objdump, un simple avr-objdump -s -j .sec1 -m avr5 challenge.hex fait l'affaire !

### Flag

MCTF{Th3_Al4Rm_Ha$_G0n3_0ff}