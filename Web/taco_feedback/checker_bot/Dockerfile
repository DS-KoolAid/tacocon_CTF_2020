FROM selenium/standalone-chrome

COPY run_headless.py /home/seluser/

COPY check_comments-cron /etc/cron.d/

RUN sudo apt update; sudo apt install -y python3-pip; sudo apt -y install cron;

RUN sudo pip3 install selenium

RUN (crontab -l -u seluser; echo "* * * * * /usr/bin/timeout -s 2 50 /usr/bin/python3 /home/seluser/run_headless.py") | crontab

RUN sudo cron