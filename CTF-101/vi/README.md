# vi

## Setup
You need to generate an SSH key pair called `tacocon_ctf_vi` & `tacocon_ctf_vi.pub` in the same directory as the Dockerfile
Then upload the private key to the CTF challenge so people can use it to log in

To run: `docker-compose up -d` 


Last lesson! Often, you will only have a command line to work with files on a system. One popular tool to create & edit files is vi.

We've left you a welcome message on our server! Download the private key and go check it out!

`ssh taco@challenges.tacocon.party -p 2222 -i tacocon.key`

*Hint: Check out a vi tutorial! http://heather.cs.ucdavis.edu/~matloff/UnixAndC/Editors/ViIntro.html*