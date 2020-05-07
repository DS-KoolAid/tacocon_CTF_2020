import socket
import os
HOST = os.environ['L_IP']  # Standard loopback interface address (localhost)
PORT = int(os.environ['L_PORT'])        # Port to listen on (non-privileged ports are > 1023)
try:
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        s.bind((HOST, PORT))
        s.listen()
        while True:
            conn, addr = s.accept()
            with conn:
                conn.sendall(b'Tacocon{HelloFromTheOtherSideOfTheInternet}\n')
except:
    print("Error!")
finally:
    s.close()
