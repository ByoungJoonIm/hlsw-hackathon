sv=server_sender
cl=server_receiver
ws=web_sender
wr=web_receiver
mh=meta.h
#CFLAGS=-D DEBUG

all: $(sv) $(cl) $(ws) $(wr)

server_sender : $(sv).c $(mh)
	gcc $(sv).c -o $(sv) ${CFLAGS}

server_receiver : $(cl).c $(mh)
	gcc $(cl).c -o $(cl) ${CFLAGS}

web_sender: $(ws).c $(mh)
	gcc $(ws).c -o $(ws) ${CFLAGS}

web_receiver: $(wr).c $(mh)
	gcc $(wr).c -o $(wr) ${CFLAGS}

clean:
	rm $(sv) $(cl) $(ws) $(wr)
