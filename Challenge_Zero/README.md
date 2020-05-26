# Setup
1. `docker-compose up -d --build`
2. `docker exec -it challengezero_challenge_zero_1 python3 create_directories.py`
3. `docker exec -it challengezero_challenge_zero_1 rm create_directories.py`
4. `docker cp bunker_locator.html challengezero_challenge_zero_1:/var/www/html/secret_files/s/a/l/s/a/bunker_locator.html`