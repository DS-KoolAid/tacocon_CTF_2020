from encryption import RSAObject, AESObject
import binascii
import logging



logger = logging.getLogger(__name__)
logger.setLevel(logging.DEBUG)
logger.addHandler(logging.StreamHandler())


def generate_mem_dump():
    with open('mem.dmp','wb') as dd:
        with open('WannaCry-Aftershock.pdf','rb') as wa:
            d=wa.read()
            dd.write(d)
        dd.write(b'\x00'*256)
        with open('private_key.der','rb') as pk:
            d=pk.read()
            dd.write(d)
        dd.write(b'\x00'*256)
        with open('w32.dll','rb') as wa:
            d=wa.read()
            dd.write(d)

def create_header(k,filesize):
    callingcard = bytes('WANNATACO!','utf-8')
    keylength = b'\x00\x01\x00\x00'
    fs=filesize.to_bytes(8,'little')
    logger.debug(f'Filesize Hex: {fs.hex()}')
    rsa = RSAObject()
    enc_key=rsa.encrypt(k)
    logger.debug(f'Orig Key: {k.hex()}')
    logger.debug(f'Encrypted Key: {enc_key[0].hex()}')
    version_number=b'\x03\x00\x00\x00'
    return callingcard+keylength+enc_key[0]+version_number+fs

def create_wntaco(filename):
    outfile=filename.split('.')[0]+'.wntco'
    aes=AESObject()
    encrypted_data=aes.encrypt_file(filename)
    logger.info(f'File Size: {aes.fs}')
    logger.info(f'Key: {aes.key.hex()}')
    with open(outfile,'wb') as fout:
        fout.write(create_header(aes.key,aes.fs))
        fout.write(encrypted_data)
    return encrypted_data,aes.key


def verify_file(encrypted_data,key):
    aes=AESObject(key=key)
    dd=aes.decrypt_file(encrypted_data)
    with open('test.jpeg','wb') as f:
        f.write(dd)
    logger.debug(f'Decrypted Data:\n{dd.hex()}')

def main():
    # create_wntaco('flag.jpg')
    generate_mem_dump()
    # verify_file(enc,k)
    

if __name__ == "__main__":
    main()
