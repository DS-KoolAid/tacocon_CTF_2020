#!/bin/bash


cd Web/sweet_tooth

docker-compose down

cd ../secret_recipe1

docker-compose down

cd ../secret_recipe2

docker-compose down

cd ../serial_taco_eater

docker-compose down

cd ../taco_feedback

docker-compose down

cd ../../Crypto/ssh_key_challenge

docker-compose down