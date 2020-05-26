#!/bin/bash

docker-compose up -d --build
docker exec -it challenge_zero_challenge_zero_1 python3 create_directories.py
docker exec -it challenge_zero_challenge_zero_1 rm create_directories.py
docker cp bunker_locator.html challenge_zero_challenge_zero_1:/var/www/html/secret_files/s/a/l/s/a/bunker_locator.html
docker cp locator.js challenge_zero_challenge_zero_1:/var/www/html/secret_files/s/a/l/s/a/locator.js