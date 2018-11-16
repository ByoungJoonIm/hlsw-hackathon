#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <arpa/inet.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <sys/socket.h>
 
#define BUFSIZE 1024
#define SENDINGUNIT 1000

void argument_check(int argc){
	if(argc != 2){
		printf("usage : ./server port_number\n");
		exit(1);
	}
}

void socket_create(int *server_socket){
	*server_socket = socket(PF_INET, SOCK_STREAM, 0);
	if(-1 == *server_socket){
		printf("server socket create failed\n");
		exit(1);
	}
}

void binding(struct sockaddr_in *server_addr, const char *port, int server_socket){
	memset(server_addr, 0, sizeof(struct sockaddr_in));
	server_addr->sin_family     = AF_INET;
	server_addr->sin_port       = htons(atoi(port));
	server_addr->sin_addr.s_addr= htonl(INADDR_ANY);

	if(-1 == bind(server_socket, (struct sockaddr*)server_addr, sizeof(struct sockaddr_in))){
		printf("bind() error");
		exit(1);
	}
}

void listen_mode(int server_socket){
	if(-1 == listen(server_socket, 5)){
		printf("wait mode setting failed\n");
		exit(1);
	}
}

void client_connect(int *client_socket, int server_socket, struct sockaddr_in *client_addr){
	int client_addr_size;

	client_addr_size  = sizeof(struct sockaddr_in);
	*client_socket     = accept(server_socket, (struct sockaddr*)client_addr, &client_addr_size);

	if (-1 == *client_socket){
		printf("client connecting failed");
		exit(1);
	}
}

void receive_message(int client_socket){
#ifdef DEBUG
	int i = 0;
#endif
	int read_size = 0;
	int fd;
	char buff_rcv[BUFSIZE];

	memset(buff_rcv, 0x00, BUFSIZE);
	read(client_socket, buff_rcv, SENDINGUNIT);
	strcat(buff_rcv, ".c");
	fd = open(buff_rcv, O_WRONLY | O_CREAT | O_TRUNC, 0644);

	while(1){	//blocked here
		read_size = read(client_socket, buff_rcv, SENDINGUNIT);

		//check eof
		if((int)(*buff_rcv) == EOF){
#ifdef DEBUG
			printf("%d\n", (int)(*buff_rcv));
			printf("finished file!\n");
#endif
			break;
		}

#ifdef DEBUG
		i++;
		printf("received%d: %s\n",i, buff_rcv);
#endif
		write(fd, buff_rcv, strlen(buff_rcv));
		memset(buff_rcv, 0x00, BUFSIZE);
	}
	close(fd);
}

void send_message(int *client_socket){
	char buff_snd[BUFSIZE];

	sprintf(buff_snd, "server ack\n");	//this message will change to compile message
	write(*client_socket, buff_snd, strlen(buff_snd)+1);
	close(*client_socket);
}

int main(int argc, char *argv[]){
	int server_socket;
	int client_socket;
	struct sockaddr_in server_addr;
	struct sockaddr_in client_addr;

	argument_check(argc);
	socket_create(&server_socket);
	binding(&server_addr, argv[1], server_socket);

	listen_mode(server_socket);

	while(1){
		client_connect(&client_socket, server_socket, &client_addr);
		receive_message(client_socket);
		send_message(&client_socket);
	}
}
