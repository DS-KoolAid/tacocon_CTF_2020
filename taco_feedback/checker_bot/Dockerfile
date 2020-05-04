FROM selenium/standalone-chrome

COPY run_headless.py /home/seluser/

RUN sudo apt update; sudo apt install -y python3-pip

RUN sudo pip3 install selenium
