FROM ubuntu:16.04

RUN apt-get update && apt-get install -y openssh-server vim
RUN mkdir /var/run/sshd

# Set up Chroot Jail
RUN mkdir -p /var/jail/
RUN mkdir -p /var/jail/dev/		
WORKDIR /var/jail/dev/
RUN mknod -m 666 null c 1 3
RUN mknod -m 666 tty c 5 0
RUN mknod -m 666 zero c 1 5
RUN mknod -m 666 random c 1 8
WORKDIR /root/
RUN chown root:root /var/jail
RUN chmod 0755 /var/jail
RUN mkdir -p /var/jail/bin
RUN mkdir -p /var/jail/usr/bin
RUN cp -v /bin/bash /var/jail/bin/
RUN cp -v /usr/bin/vi /var/jail/usr/bin
RUN mkdir -p /var/jail/lib/x86_64-linux-gnu
RUN mkdir -p /var/jail/lib64
RUN mkdir -p /var/jail/usr/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libtinfo.so.5 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libdl.so.2 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libc.so.6 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libm.so.6 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libselinux.so.1 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libacl.so.1 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libpthread.so.0 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libpcre.so.3 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libattr.so.1 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libexpat.so.1 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libz.so.1 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib/x86_64-linux-gnu/libutil.so.1 /var/jail/lib/x86_64-linux-gnu/
RUN cp -v /lib64/ld-linux-x86-64.so.2 /var/jail/lib64/
RUN cp -v /usr/lib/x86_64-linux-gnu/libgpm.so.2 /var/jail/usr/lib/x86_64-linux-gnu/
RUN cp -v /usr/lib/x86_64-linux-gnu/libpython3.5m.so.1.0 /var/jail/usr/lib/x86_64-linux-gnu/
RUN mkdir /var/jail/etc
RUN adduser taco
RUN cat /etc/passwd | grep taco >> /var/jail/etc/passwd
COPY sshd_chroot /root/sshd_chroot
RUN cat sshd_chroot >> /etc/ssh/sshd_config
RUN rm /root/sshd_chroot

# Set up SSH Key
RUN mkdir /home/taco/.ssh
RUN chown -R taco: /home/taco/.ssh
COPY tacocon_ctf_vi.pub /home/taco/.ssh/authorized_keys

# Add challenge files
RUN mkdir -p /var/jail/home/taco
COPY welcome_to_tacocon.txt /var/jail/home/taco/welcome_to_tacocon.txt
COPY bashrc /var/jail/home/taco/.bashrc
COPY profile /var/jail/home/taco/.profile

WORKDIR /var/jail/home/taco

EXPOSE 22
CMD ["/usr/sbin/sshd", "-D"]