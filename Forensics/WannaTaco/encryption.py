import os, struct,ast
import Crypto
from Crypto.Cipher import AES
from Crypto.PublicKey import RSA
from Crypto import Random


class RSAObject:

    def __init__(self):
        self.gen_rsa_key()

    def gen_rsa_key(self):
        random_generator = Random.new().read
        key = RSA.generate(2048, random_generator)
        self.key=key
        self.publickey = key.publickey()
        self.privatekey = key.exportKey()
        with open('public_key','wb') as pub:
            pub.write(self.publickey.exportKey())
        with open('private_key','wb') as priv:
            priv.write(self.privatekey)
        


    def encrypt(self,data):
        enc_data=self.publickey.encrypt(data,16)
        return enc_data

    def decrypt(self,enc_data):
        data=self.key.decrypt(enc_data)
        return data

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
