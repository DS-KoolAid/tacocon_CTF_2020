import os, struct,ast
import Crypto
from Crypto.Cipher import AES

class AESObject():

    def __init__(self,key=bytes(),mode=AES.MODE_CBC,IV=16 * '\x00'):
        if key==b'':
            self.key=os.urandom(16)
        else:
            self.key=key
        self.mode=mode
        self.IV=IV


    def encrypt_file(self, filename,chunksize=64*1024):
        infile=filename
        encryptor = AES.new(self.key, self.mode, IV=self.IV)
        encrypted_data=bytes()
        filesize = os.path.getsize(infile)
        with open(infile,'rb') as fin:
            while True:
                chunk = fin.read(chunksize)
                if len(chunk) == 0:
                    break
                elif len(chunk) % 16 != 0:
                    chunk += b' ' * (16 - len(chunk) % 16)
                encrypted_data+=encryptor.encrypt(chunk)
        self.fs=filesize
        return encrypted_data

    def decrypt_file(self,encrypted_data):
        decryptor = AES.new(self.key, self.mode, IV=self.IV)
        decrypted_data = decryptor.decrypt(encrypted_data)
        return decrypted_data


def attempt_decrypt():
    time_seed = 1589675269.2449
    while True:
        time_seed = round(time_seed, 4)
        key = gen_random_strng(time_seed, 32)
        kb = str.encode(key)
        print(time_seed, key)
        dbytes = decrypt_file("flag_zpfRAIq2WrjAgXiq.taco", kb)
        with open(f"flag.taco",'wb') as f:
            f.write(dbytes)
        if imghdr.what("flag.taco") == "jpeg":
            print(key)
            break

        time_seed += .0001

def main():
    k="ngSt3Tf5BEiQxK7NtqeHVIQnV07y0RRG"
    str.encode(k)
    aes = AESObject(key=k)
    enc_data=b''
    with open('flag_zpfRAIq2WrjAgXiq.taco','rb') as flag:
        enc_data+=flag.read()
    dd=aes.decrypt_file(enc_data)
    with open('flag_decrypted.jpg','wb') as flag:
        flag.write(dd)

