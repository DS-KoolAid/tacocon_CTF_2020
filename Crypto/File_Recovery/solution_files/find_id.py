import random

def gen_random_string(length,t):
    random.seed(t)
    random_string=""
    picker="0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"
    for i in range(0,length):
        random_string+=picker[random.randint(0, 61)]
    return random_string

def main():
    infection_id="zpfRAIq2WrjAgXiq"
    t= 1589675100
    while t != 1589675400:
        print(f" Attempting time: {t}",end="\r")
        if gen_random_string(16,t) == infection_id:
            print(f"[*] Match Found!\nSeed: {t}")
            break
        t+=.0001
        t=round(t,4)

if __name__ == "__main__":
    main()
