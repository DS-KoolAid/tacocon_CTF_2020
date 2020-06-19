# Forensics Solutions

## Forensics 200 - Zombie Taco

This challenge focuses on a forensic technique of **file carving**. 

[Infosec Institute](https://resources.infosecinstitute.com/file-carving/#gref) says it best: 

*File carving is a process used in computer forensics to extract data from a disk drive or other storage device without the assistance of the file system that originality created the file. It is a method that recovers files at unallocated space without any file information and is used to recover data and execute a digital forensic investigation. It also called “carving,” which is a general term for extracting structured data out of raw data, based on format specific characteristics present in the structured data.*

The challenge give the hint that the file we are looking for may have been deleted, thus we need to *resurrect* it from the unallocated memory space that the challenge provides. 

There are many ways to do this, some automated and some manual. This solution guide will detail the manual process, as it's always better to understand what the tools you run are actually doing. 

Lets start by opening the file up in a hex editor. There are plenty of hex editors out there, even online ones like [Hexed.it](https://hexed.it/)

Scrolling through the file in hex, we can see that there is a breadcrumb left by the user: 

![For 200](images/for200-1.png)

This tells us that we are looking for a JPEG file in this dump.

To find a JPEG file, we should look for the file signature of a JPEG files. A file signature is the first few bytes of a file that identify the type of content in a file. There are a few different file signatues for JPEG files, but most start with `FF D8 FF` in hex. [Here](https://www.filesignatures.net/index.php?page=all&order=SIGNATURE&sort=DESC&alpha=) is a good resource for file signatures. 

Searching the dump file for `FF D8 FF`:

![For 200](images/for200-2.png)

There is one match at the address `0x0010A29C`. 

Going to that address in the file:

![For 200](images/for200-3.png)

This match seems to be at the beginning of a file, as it is preceded by null bytes (`0x00`). Additionally the keyword `JFIF` can be seen in the text, which provides additional confirmation that this is an image file. 

The next step is to copy out that hex to another file in the hex editor, starting with the `FF D8 FF` and ending with the hex right before a null byte padding (`0x00`). 

Save the new file and open it: 

![For 200](images/for200-4.jpg)

**An easier way to do this is to use a program called binwalk, which will extract the files automatically** 

## Forensics 300 - tacosay
You are given a binary file. If you run it, you get an ASCII art taco saying `What does the taco say?`
![tacosay.png](images/tacosay.png)

Running it with a command line argument results in the taco replying with `It does not say <argument-given>`
![tacosay-invalid.png](images/tacosay-invalid.png)

So based on this information, we probably need to find the right input to give, in order to get the program to output the flag.

First thing we can try is running strings on the binary to see if we find anything interesting inside the file.
`strings tacosay`
![tacosay-strings.png](images/tacosay-strings.png)

There's a couple interesting things - a string `Ring-ding-ding-ding-dingeringeding!` and a YouTube link `https://www.youtube.com/watch?v=jofNR_WkoCE`.

Let's try giving the first string as an input.
`./tacosay Ring-ding-ding-ding-dingeringeding!`
![tacosay-ring.png](images/tacosay-ring.png)

That gives us the YouTube link. Going to that link reveals the video `Ylvis - The Fox (What Does The Fox Say?) [Official music video HD]` and this actually ends up being a dead-end. We added it as an Easter Egg :)

Since there's nothing else from the strings ouput that is useful, the next step is trying to disassemble the program and then potentially debug it.

One way to dissamble the binary is to use the `objdump` command, specifically `objdump tacosay --disassemble > tacosay.disassemble` which outputs the assembly code of the binary to a file.
Looking at the dissambly, we can spot a few key parts.

First off there is a `main` function which is likely where the entrypoint of this program, so let's take a closer look.
![tacosay-disas-main.png](images/tacosay-disas-main.png)

Looking at the assembly code of `main`, we notice a call to the `check_input` function. This is likely where the check happens to see if the correct input was given. Let's take a closer look at the code of that function.
![tacosay-disas-check.png](images/tacosay-disas-check.png)

We can see further down in the `check_input` function, a call made to `strcmp`, making use of the `eax` register . This is likely where the check takes place so we need to find a way to view the contents of the `eax` register as this check.
![tacosay-disas-strcmp.png](images/tacosay-disas-strcmp.png)

There are two options. 
First one: there's a handy Linux command called `ltrace`. You can use to run another command and it will log all library calls made by the command dynamically. Since `strcmp` is a call to a library, it should pick it up.
`ltrace ./tacosay hi`

And you can see that it does in fact pick up the `strcmp` call and the correct input is `m00o!`
![tacosay-ltrace.png](images/tacosay-ltrace.png)

Alternatively, you can run this program with a debugger to step through as it runs and find the exact moment it does the check. Let's use `gdb` for this.

Start the program in gdb `gdb tacosay`, and then let's set a breakpoint on the main function `b main`. Now run the program with an input `r hi`.

Next, we should hit our breakpoint. Let's take a look at the disassembly again to see where we're at `disas` and we can see we're at the start of the main function and further below, we see a call to `check_input`. So let's set another breakpoint there, `b check_input` and then continue `c`
![tacosay-gdb-main.png](images/tacosay-gdb-main.png)

Looking at the dissambley output again `disas`, we see further down the `strcmp` call happens at address `0x56556292`, so let's set another breakpoint at that address `b *0x56556292` and continue `c`.
![tacosay-gdb-strcmp.png](images/tacosay-gdb-strcmp.png)


Now, we should check the value of the `eax` register to see what the correct input is `x/s $eax`, and we find the correct input to be `m00o!`
![tacosay-gdb-eax.png](images/tacosay-gdb-eax.png)


Now that we have correct input, let's feed it to the program and get the flag! `Tacocon{R3verseEngineeringIsAllITacoAbout}`
![tacosay-flag.png](images/tacosay-flag.png)


## Forensics 500 - WannaTaco

This challenge is modeled after the WannaCry ransomware. The way that WannaCry worked was that it would generate a RSA key pair per infection. It would then generate an AES key per encrypted file. The public key was used to identify the victim; the private RSA key was used to encrypt the AES key per file. The encrypted AES key would then be placed in the file headers of the corresponding encrypted file. [FireEye](https://www.fireeye.com/blog/threat-research/2017/05/wannacry-malware-profile.html) has a really good explination of the malware. 

This challenge can be broken into three parts. The first is extracting the Private RSA key from the dump. Then using that RSA private key to decrypt the AES key in the headers of the encrypted file. Finally, using the decrypted AES key to decrypt the rest of the file. 

### Extracting the private RSA Key

This is the easiest part of the challenge. To do this, run: 

```binwalk -e mem.dump``` 

This will create a few files in the current directory. One of them will be an RSA private key in the `der` format. 

Lets convert this to pem format, as its easier to deal with. 

```openssl pkey -inform DER -outform PEM -text -in private_key.der -out private.pem```

The contents of `private.pem` should look like:

```
-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQCiTLGjEBO7R6PO
IS1hov9MAPF+PAwCu6U0etVyzw6if/OR1mv5PRbG/pmRhmET1YfrD9B++Yq/DK5J
jhLbvYsPmMHiDqWo+/9R0/OeieGkD5yv8nbx8wNBbePC5I28qwEfiIAudoWthBpe
yS/P6UCPRlKAw1DMaVSrLUYqPsFinvLaWAsC/jCmoeXk0NspNuNR+HXXsn0vuDuG
IeFavMXC/4R8MvVo754XPA3TdcoQ0+incwV/oUDfg0lXu3nEesVpiThoRvG/vh2U
/O1QSAAiNbGIGi95LQYecttxo87lgJHyb2HAn9P3Bb+AIlmmlW4tkPDExncqftGi
/vlXuzJJAgMBAAECggEBAJ3voiF7QKhLs7Sghofv1R4CAP8Fse5q6f4i1lmt8qDh
gIXXsiTNdL/a/Fgn+4oQjf6J2ivl7EW0MlpzvhhF3/Aih/HSrRS/fRsE9Zq+tGwx
oRl7CpKyF+Xw6OY8AU2q3yHvdEVCox1SY1L/1t4tLtz94sVYy+TPT0xwd0oe3ZN4
aW2P8fMOPCyATynkWqE/eaxcUUFFOWSSNnqRUCs+xUD/plFlBBYcWeUeMccFujBx
eSuNKHDChvAyVFEpowpv+SkTilp8YzSGiAPbAYO+MNDjetTs5/zTk+LdA2imioid
FQ8igBnSfLJ86sKMUNzn+jJluOp3GWeGsIYiikRV//ECgYEAuRiAaNUyCDMLLwkp
S6W9kmHR9Btz6UWTI6b8gD4WpMls8rikM+79fGF1GSjf4pJ9BBV8FeD0UvNxSFQr
uutB663+Q43mW4Ljaf2EjmbgHdCUJlWoOa9pOVM2h01pRE9OxsYrZgIpDXe77M6j
KYIXWPaTTsPCU+w1Tr3v09+m5I0CgYEA4Hit+yTG7DVyxfVTo7TGWOghWJ7UxGPO
YlvAvyHY8xEA2APDE+nlzODBg1S+6mUgzeLmWo9j0ERaA9uiIRsMqCFIG5O63pep
oHiNrRmBCtIpZgI5hJ2G7VexoMKeIn8CsoeHNfWZdZCWM9piX4QmQfh8wi0jpBTt
683lwVdve60CgYEArkAbuxVh2Yg8Mhac0sOAWQtP/U/O6j9+iqTMtuo8pPufXk1n
ACEwb+TLuVjalFE18h9LxskVGfZmoiHjXT/Wukn9wZkX0PTCpOhu3ySIPmk632/q
RAwXskjdX7kHrbA/yC+NcaX9AdnDh+bsgcofsrfG6/KswhbwBGYZHkxBsI0CgYEA
ottrftaD7EQq7Sy8bf1uGnrwFpfFzmaLChl/kixAdrlTX2X7VqtQKoC2ZU5K5UxR
rI5+ih2WUTgGBt6GlnZFjIX5Buj7nxtx2hcc0wW59dvcZUIf8PNJPVFucjBBAs4b
auOhWajCmeU41I4Q6TO7fgmGmmqdfSIiK/7KPqftHlECgYAB4auooJVbAmbQ/NhU
SEjsPWcCMPpRbEAObRsRBt7iWyF4W66fqeRL6eK2fvQMX7Urvj2uCXNJNFv6a9J2
0mE3cKaZvg1UejP4b8MdzNsxn7nFivpFFU9L3T3DgxNqI/A8NDWk3CKbJAHpx29E
GFlgnU8svKguhD5uuGW2AdzFlQ==
-----END PRIVATE KEY-----
Private-Key: (2048 bit)
modulus:
    00:a2:4c:b1:a3:10:13:bb:47:a3:ce:21:2d:61:a2:
    ff:4c:00:f1:7e:3c:0c:02:bb:a5:34:7a:d5:72:cf:
    0e:a2:7f:f3:91:d6:6b:f9:3d:16:c6:fe:99:91:86:
    61:13:d5:87:eb:0f:d0:7e:f9:8a:bf:0c:ae:49:8e:
    12:db:bd:8b:0f:98:c1:e2:0e:a5:a8:fb:ff:51:d3:
    f3:9e:89:e1:a4:0f:9c:af:f2:76:f1:f3:03:41:6d:
    e3:c2:e4:8d:bc:ab:01:1f:88:80:2e:76:85:ad:84:
    1a:5e:c9:2f:cf:e9:40:8f:46:52:80:c3:50:cc:69:
    54:ab:2d:46:2a:3e:c1:62:9e:f2:da:58:0b:02:fe:
    30:a6:a1:e5:e4:d0:db:29:36:e3:51:f8:75:d7:b2:
    7d:2f:b8:3b:86:21:e1:5a:bc:c5:c2:ff:84:7c:32:
    f5:68:ef:9e:17:3c:0d:d3:75:ca:10:d3:e8:a7:73:
    05:7f:a1:40:df:83:49:57:bb:79:c4:7a:c5:69:89:
    38:68:46:f1:bf:be:1d:94:fc:ed:50:48:00:22:35:
    b1:88:1a:2f:79:2d:06:1e:72:db:71:a3:ce:e5:80:
    91:f2:6f:61:c0:9f:d3:f7:05:bf:80:22:59:a6:95:
    6e:2d:90:f0:c4:c6:77:2a:7e:d1:a2:fe:f9:57:bb:
    32:49
publicExponent: 65537 (0x10001)
privateExponent:
    00:9d:ef:a2:21:7b:40:a8:4b:b3:b4:a0:86:87:ef:
    d5:1e:02:00:ff:05:b1:ee:6a:e9:fe:22:d6:59:ad:
    f2:a0:e1:80:85:d7:b2:24:cd:74:bf:da:fc:58:27:
    fb:8a:10:8d:fe:89:da:2b:e5:ec:45:b4:32:5a:73:
    be:18:45:df:f0:22:87:f1:d2:ad:14:bf:7d:1b:04:
    f5:9a:be:b4:6c:31:a1:19:7b:0a:92:b2:17:e5:f0:
    e8:e6:3c:01:4d:aa:df:21:ef:74:45:42:a3:1d:52:
    63:52:ff:d6:de:2d:2e:dc:fd:e2:c5:58:cb:e4:cf:
    4f:4c:70:77:4a:1e:dd:93:78:69:6d:8f:f1:f3:0e:
    3c:2c:80:4f:29:e4:5a:a1:3f:79:ac:5c:51:41:45:
    39:64:92:36:7a:91:50:2b:3e:c5:40:ff:a6:51:65:
    04:16:1c:59:e5:1e:31:c7:05:ba:30:71:79:2b:8d:
    28:70:c2:86:f0:32:54:51:29:a3:0a:6f:f9:29:13:
    8a:5a:7c:63:34:86:88:03:db:01:83:be:30:d0:e3:
    7a:d4:ec:e7:fc:d3:93:e2:dd:03:68:a6:8a:88:9d:
    15:0f:22:80:19:d2:7c:b2:7c:ea:c2:8c:50:dc:e7:
    fa:32:65:b8:ea:77:19:67:86:b0:86:22:8a:44:55:
    ff:f1
prime1:
    00:b9:18:80:68:d5:32:08:33:0b:2f:09:29:4b:a5:
    bd:92:61:d1:f4:1b:73:e9:45:93:23:a6:fc:80:3e:
    16:a4:c9:6c:f2:b8:a4:33:ee:fd:7c:61:75:19:28:
    df:e2:92:7d:04:15:7c:15:e0:f4:52:f3:71:48:54:
    2b:ba:eb:41:eb:ad:fe:43:8d:e6:5b:82:e3:69:fd:
    84:8e:66:e0:1d:d0:94:26:55:a8:39:af:69:39:53:
    36:87:4d:69:44:4f:4e:c6:c6:2b:66:02:29:0d:77:
    bb:ec:ce:a3:29:82:17:58:f6:93:4e:c3:c2:53:ec:
    35:4e:bd:ef:d3:df:a6:e4:8d
prime2:
    00:e0:78:ad:fb:24:c6:ec:35:72:c5:f5:53:a3:b4:
    c6:58:e8:21:58:9e:d4:c4:63:ce:62:5b:c0:bf:21:
    d8:f3:11:00:d8:03:c3:13:e9:e5:cc:e0:c1:83:54:
    be:ea:65:20:cd:e2:e6:5a:8f:63:d0:44:5a:03:db:
    a2:21:1b:0c:a8:21:48:1b:93:ba:de:97:a9:a0:78:
    8d:ad:19:81:0a:d2:29:66:02:39:84:9d:86:ed:57:
    b1:a0:c2:9e:22:7f:02:b2:87:87:35:f5:99:75:90:
    96:33:da:62:5f:84:26:41:f8:7c:c2:2d:23:a4:14:
    ed:eb:cd:e5:c1:57:6f:7b:ad
exponent1:
    00:ae:40:1b:bb:15:61:d9:88:3c:32:16:9c:d2:c3:
    80:59:0b:4f:fd:4f:ce:ea:3f:7e:8a:a4:cc:b6:ea:
    3c:a4:fb:9f:5e:4d:67:00:21:30:6f:e4:cb:b9:58:
    da:94:51:35:f2:1f:4b:c6:c9:15:19:f6:66:a2:21:
    e3:5d:3f:d6:ba:49:fd:c1:99:17:d0:f4:c2:a4:e8:
    6e:df:24:88:3e:69:3a:df:6f:ea:44:0c:17:b2:48:
    dd:5f:b9:07:ad:b0:3f:c8:2f:8d:71:a5:fd:01:d9:
    c3:87:e6:ec:81:ca:1f:b2:b7:c6:eb:f2:ac:c2:16:
    f0:04:66:19:1e:4c:41:b0:8d
exponent2:
    00:a2:db:6b:7e:d6:83:ec:44:2a:ed:2c:bc:6d:fd:
    6e:1a:7a:f0:16:97:c5:ce:66:8b:0a:19:7f:92:2c:
    40:76:b9:53:5f:65:fb:56:ab:50:2a:80:b6:65:4e:
    4a:e5:4c:51:ac:8e:7e:8a:1d:96:51:38:06:06:de:
    86:96:76:45:8c:85:f9:06:e8:fb:9f:1b:71:da:17:
    1c:d3:05:b9:f5:db:dc:65:42:1f:f0:f3:49:3d:51:
    6e:72:30:41:02:ce:1b:6a:e3:a1:59:a8:c2:99:e5:
    38:d4:8e:10:e9:33:bb:7e:09:86:9a:6a:9d:7d:22:
    22:2b:fe:ca:3e:a7:ed:1e:51
coefficient:
    01:e1:ab:a8:a0:95:5b:02:66:d0:fc:d8:54:48:48:
    ec:3d:67:02:30:fa:51:6c:40:0e:6d:1b:11:06:de:
    e2:5b:21:78:5b:ae:9f:a9:e4:4b:e9:e2:b6:7e:f4:
    0c:5f:b5:2b:be:3d:ae:09:73:49:34:5b:fa:6b:d2:
    76:d2:61:37:70:a6:99:be:0d:54:7a:33:f8:6f:c3:
    1d:cc:db:31:9f:b9:c5:8a:fa:45:15:4f:4b:dd:3d:
    c3:83:13:6a:23:f0:3c:34:35:a4:dc:22:9b:24:01:
    e9:c7:6f:44:18:59:60:9d:4f:2c:bc:a8:2e:84:3e:
    6e:b8:65:b6:01:dc:c5:95
```

We can git rid of everything after `-----END PRIVATE KEY-----`. So our private key file now looks like this: 

```
-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQCiTLGjEBO7R6PO
IS1hov9MAPF+PAwCu6U0etVyzw6if/OR1mv5PRbG/pmRhmET1YfrD9B++Yq/DK5J
jhLbvYsPmMHiDqWo+/9R0/OeieGkD5yv8nbx8wNBbePC5I28qwEfiIAudoWthBpe
yS/P6UCPRlKAw1DMaVSrLUYqPsFinvLaWAsC/jCmoeXk0NspNuNR+HXXsn0vuDuG
IeFavMXC/4R8MvVo754XPA3TdcoQ0+incwV/oUDfg0lXu3nEesVpiThoRvG/vh2U
/O1QSAAiNbGIGi95LQYecttxo87lgJHyb2HAn9P3Bb+AIlmmlW4tkPDExncqftGi
/vlXuzJJAgMBAAECggEBAJ3voiF7QKhLs7Sghofv1R4CAP8Fse5q6f4i1lmt8qDh
gIXXsiTNdL/a/Fgn+4oQjf6J2ivl7EW0MlpzvhhF3/Aih/HSrRS/fRsE9Zq+tGwx
oRl7CpKyF+Xw6OY8AU2q3yHvdEVCox1SY1L/1t4tLtz94sVYy+TPT0xwd0oe3ZN4
aW2P8fMOPCyATynkWqE/eaxcUUFFOWSSNnqRUCs+xUD/plFlBBYcWeUeMccFujBx
eSuNKHDChvAyVFEpowpv+SkTilp8YzSGiAPbAYO+MNDjetTs5/zTk+LdA2imioid
FQ8igBnSfLJ86sKMUNzn+jJluOp3GWeGsIYiikRV//ECgYEAuRiAaNUyCDMLLwkp
S6W9kmHR9Btz6UWTI6b8gD4WpMls8rikM+79fGF1GSjf4pJ9BBV8FeD0UvNxSFQr
uutB663+Q43mW4Ljaf2EjmbgHdCUJlWoOa9pOVM2h01pRE9OxsYrZgIpDXe77M6j
KYIXWPaTTsPCU+w1Tr3v09+m5I0CgYEA4Hit+yTG7DVyxfVTo7TGWOghWJ7UxGPO
YlvAvyHY8xEA2APDE+nlzODBg1S+6mUgzeLmWo9j0ERaA9uiIRsMqCFIG5O63pep
oHiNrRmBCtIpZgI5hJ2G7VexoMKeIn8CsoeHNfWZdZCWM9piX4QmQfh8wi0jpBTt
683lwVdve60CgYEArkAbuxVh2Yg8Mhac0sOAWQtP/U/O6j9+iqTMtuo8pPufXk1n
ACEwb+TLuVjalFE18h9LxskVGfZmoiHjXT/Wukn9wZkX0PTCpOhu3ySIPmk632/q
RAwXskjdX7kHrbA/yC+NcaX9AdnDh+bsgcofsrfG6/KswhbwBGYZHkxBsI0CgYEA
ottrftaD7EQq7Sy8bf1uGnrwFpfFzmaLChl/kixAdrlTX2X7VqtQKoC2ZU5K5UxR
rI5+ih2WUTgGBt6GlnZFjIX5Buj7nxtx2hcc0wW59dvcZUIf8PNJPVFucjBBAs4b
auOhWajCmeU41I4Q6TO7fgmGmmqdfSIiK/7KPqftHlECgYAB4auooJVbAmbQ/NhU
SEjsPWcCMPpRbEAObRsRBt7iWyF4W66fqeRL6eK2fvQMX7Urvj2uCXNJNFv6a9J2
0mE3cKaZvg1UejP4b8MdzNsxn7nFivpFFU9L3T3DgxNqI/A8NDWk3CKbJAHpx29E
GFlgnU8svKguhD5uuGW2AdzFlQ==
-----END PRIVATE KEY-----
```

### Decrypting the AES Key

Now that we have the private RSA key, we can move forward with decrypting the AES key used to encrypt the original file. 

To find the encrypted AES key, we need to understand the file format of an encrypted WannaCry file (or WannaTaco file in this case). 

Looking at the WannaCry file structure that is outlined in the [FireEye](https://www.fireeye.com/blog/threat-research/2017/05/wannacry-malware-profile.html) malware profile: 

![For 500](images/for500-1.png)

We can assume that our WannaTaco file is structed the same way. Let's open up the file in a hex editor and check out the begining: 

![For 500](images/for500-2.png)

We can see that the first 10 bytes are the ransomware calling card. This varies slightly from the WannaCry structure, but it looks like the rest of the file header is consistent with WannaCry. 

The next 4 bytes are the length of the encrypted key: `00 01 00 00`. If we convert this hex to decimal we get 65536. This is incorrect. Thinking about WannaCry, it only affects Windows systems. Windows writes information like file size to storage in little endian. Therefore the hex value is really `00 00 01 00`, which is 256 in decimal format. 

Now that we have the encrypted key length, we need to copy out the next 256 bytes: 

![For 500](images/for500-3.png)

Copy this into a new file and save it. We now have the encrypted AES key. 

There are a few ways to decrypt this, in this example we will use python:

```python
import Crypto
from Crypto.PublicKey import RSA


rsa_key=RSA.importKey(open('private.pem','rb').read())
enc_data=open('enc_aes_key','rb').read()
decrypted_data=rsa_key.decrypt(enc_data)
open('decrypted_aes_key','wb').write(decrypted_data)
```

### Decrypt the file

Now that we have the decrypted AES key, the next step is to copy out the encrypted contents of the original file. 

![for 500](images/for500-4.png)

Save this data to another file. We can use a python script to decrypt this data: 

```python
import Crypto
from Crypto.Cipher import AES

aes_ob=AES.new(open('decrypted_aes_key','rb').read(),AES.MODE_CBC,IV=16*'\x00')
decrypted_data=aes_ob.decrypt(open('enc_file','rb').read())
open('orig_file','wb').write(decrypted_data)
```

If we open `orig_file`, a jpeg loads: 

![for 500](images/for500-5.jpg)