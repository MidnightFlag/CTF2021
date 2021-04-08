# Endianness

## Catégorie

Réseau

## Description

Lors d'une partie de Ping-Pong, un échange à été très disputer avec beaucoup d'intensité par les joueurs. Essayer de comprendre pourquoi :)

Format : MCTF{}

## Hints

Hint 1 : "C'est la base !"

hint 2 : ""

## Auteur

N3oWind

## Solution

Tout d'abord, on ouvre la capture ping_pong.pcap dans l'outil wireshark. On retrouve une multitutde d'échange du protocol ICMP qui correspond à un ping. On peut commencer par filtrer la capture sur les requêtes ou sur les réponses. Pour cela "icmp.type==8" (request) ou "icmp.type==0" (reply)

Ensuite on remarque que la trame 49 est différentes des autres puisque qu'on retrouve de la data à l'intérieur. On va donc exfiltrer la data avec tshark qui est la version CLI de wireshark.

Exfiltrer la data avec la commande : 

```
tshark -r toto.pcap -Y "icmp" -T fields -e data.text | sort | uniq -c
```

On obtient :

> B2BCABB984BDCE919ECE8D9AA0968CA092CF8DCCA08CCC8786A08B979E91A0979A879E82

![alt](Images/ping_pong.png)
<br/>

Grâce au hint "c'est la base", on sait qu'on doit changer notre hexa en binaire (base2) :

> 101100101011110010101011101110011000010010111101110011101001000110011110110011101000110110011010101000001001011010001100101000001001001011001111100011011100110010100000100011001100110010000111100001101010000010001011100101111001111010010001101000001001011110011010100001111001111010000010

On inverse le code binaire (les 0 en 1 et les 1 en  0) grâce à un petit script python par exemple :

```python
#!/usr/bin/env python3

bit_s = '101100101011110010101011101110011000010010111101110011101001000110011110110011101000110110011010101000001001011010001100101000001001001011001111100011011100110010100000100011001100110010000111100001101010000010001011100101111001111010010001101000001001011110011010100001111001111010000010'
inverse_s = ''
  
for i in bit_s:
    
    if i == '0':
        inverse_s += '1'
          
    else:
        inverse_s += '0'
          
print("Inversed string is ",
      inverse_s)
```



> 010011010100001101010100010001100111101101000010001100010110111001100001001100010111001001100101010111110110100101110011010111110110110100110000011100100011001101011111011100110011001101111000011110010101111101110100011010000110000101101110010111110110100001100101011110000110000101111101

Puis on refait un binaire to hexacécimal :

> 4D4354467B42316E613172655F69735F6D3072335F733378795F7468616E5F686578617D

Et enfin héxadécimal to ascii text : 

> MCTF{B1na1re_is_m0r3_s3xy_than_hexa}
