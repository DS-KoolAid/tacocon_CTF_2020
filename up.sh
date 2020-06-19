#!/bin/bash


cd Web/sweet_tooth

docker-compose up -d

cd ../secret_recipe1

docker-compose up -d

cd ../secret_recipe2

docker-compose up -d

cd ../serial_taco_eater

docker-compose up -d

cd ../taco_feedback

docker-compose up -d

cd ../../Crypto/ssh_key_challenge

docker-compose up -d

cd ../../CTF-101/web-101

docker-compose up -d

cd ../network-101

docker-compose up -d

cd ../vi

docker-compose up -d