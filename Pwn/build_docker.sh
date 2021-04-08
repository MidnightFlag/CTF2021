#!/bin/bash

sudo docker build ./1_introduction/    -t introduction:latest    --quiet
sudo docker build ./2_prison_break/    -t prison_break:latest    --quiet
sudo docker build ./3_return_room/     -t return_room:latest     --quiet
sudo docker build ./4_canary_friendly/ -t canary_friendly:latest --quiet
sudo docker build ./5_random_rope/     -t random_rope:latest     --quiet

echo " [*] Listing docker images :"

sudo docker images
