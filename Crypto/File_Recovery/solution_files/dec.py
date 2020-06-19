import random
import Crypto
from Crypto.Cipher import AES

class AESObject():

    def __init__(self,key,mode=AES.MODE_CBC,IV=16 * '\x00'):
        self.key=key
        self.mode=mode
        self.IV=IV


    def decrypt_file(self,encrypted_data):
        decryptor = AES.new(self.key, self.mode, IV=self.IV)
        decrypted_data = decryptor.decrypt(encrypted_data)
        return decrypted_data


def gen_random_string(length,t):
    random.seed(t)
    random_string=""
    picker="0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"
    for i in range(0,length):
        random_string+=picker[random.randint(0, 61)]
    return random_string

def main():
    start=1589675269.2449
    end = start+.0020
    enc_data=b''
    with open('flag_zpfRAIq2WrjAgXiq.taco','rb') as f:
        enc_data=f.read()
    while start != end:
        print(f"Generating file for: {str(start)}")
        key=gen_random_string(32,start)
        aes=AESObject(key)
        test = aes.decrypt_file(enc_data)
        with open(f"{str(start)}.jpg","wb") as f:
            f.write(test)
        start+=.0001
        start=round(start,4)

if __name__ == "__main__":
    main()
