def generate_mem_dump():
    with open('mem_zombie_Taco.dmp','wb') as dd:
        dd.write(b'\x00'*256)
        with open('menu.pdf','rb') as wa:
            d=wa.read()
            dd.write(d)
        dd.write(b'\x00'*256)
        with open('flag.jpg','rb') as pk:
            d=pk.read()
            dd.write(d)
        dd.write(b'\x00'*256)
        with open('w32.dll','rb') as wa:
            d=wa.read()
            dd.write(d)
        dd.write(b'\x00'*256)
        with open('egg.txt','rb') as wa:
            d=wa.read()
            dd.write(d)
        dd.write(b'\x00'*256)
def main():
    generate_mem_dump()

if __name__ == "__main__":
    main()