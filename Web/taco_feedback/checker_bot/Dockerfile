FROM selenium/standalone-chrome

COPY run_headless.py /home/seluser/

COPY check_comments-cron /etc/cron.d/

RUN sudo chmod 644 /etc/cron.d/check_comments-cron

RUN sudo apt update; sudo apt install -y python3-pip; sudo apt -y install cron;

RUN crontab /etc/cron.d/check_comments-cron

RUN sudo pip3 install selenium

CMD sudo service cron start && /opt/bin/entry_point.sh