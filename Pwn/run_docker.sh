#!/bin/bash

sudo docker run -d introduction
sudo docker run -d prison_break
sudo docker run -d return_room
sudo docker run -d canary_friendly
sudo docker run -d random_rope

echo " [*] Listing docker containers :"

sudo docker container ls
