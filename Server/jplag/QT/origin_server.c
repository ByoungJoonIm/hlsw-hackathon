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
 
int main(int argc, char *argv[]){
	int server_socket;
	int client_socket;
	int client_addr_size;

	struct sockaddr_in server_addr;
	struct sockaddr_in client_addr;

	char buff_rcv[BUFSIZE];
	char buff_snd[BUFSIZE];

	int fd;		//will write file

	argument_check(argc);
	socket_create(&server_socket);

	/*
	 	socket and ip, port bind
	 */
	memset(&server_addr, 0, sizeof(server_addr));
	server_addr.sin_family     = AF_INET;
	server_addr.sin_port       = htons(atoi(argv[1]));
	server_addr.sin_addr.s_addr= htonl(INADDR_ANY);

	if(-1 == bind(server_socket, (struct sockaddr*)&server_addr, sizeof(server_addr))){
		printf("bind() error");
		exit(1);
	}


	/*
	   wait mode(listen)
	 */
	if(-1 == listen(server_socket, 5)){
		printf("wait mode setting failed\n");
		exit(1);
	}

	while(1){
		memset(buff_rcv, 0x00, BUFSIZE);

		client_addr_size  = sizeof( client_addr);
		client_socket     = accept( server_socket, (struct sockaddr*)&client_addr, &client_addr_size);

		if (-1 == client_socket){
			printf("client connecting failed");
			exit(1);
		}

		int i = 0;
		int read_size = 0;
		read(client_socket, buff_rcv, SENDINGUNIT);
		strcat(buff_rcv, ".c");
		fd = open(buff_rcv, O_WRONLY | O_CREAT | O_TRUNC, 0644);

		while(1){	//blocked here
			read_size = read(client_socket, buff_rcv, SENDINGUNIT);
			
			//check eof
			if(read_size == 0 || (int)(*buff_rcv) == EOF){
				printf("%d\n", (int)(*buff_rcv));
				printf("finished file!\n");
				break;
			}

			i++;
			printf("received%d: %s\n",i, buff_rcv);
			write(fd, buff_rcv, strlen(buff_rcv));
			memset(buff_rcv, 0x00, BUFSIZE);
		}

		sprintf(buff_snd, "server ack\n");	//this message will change to compile message
		write(client_socket, buff_snd, strlen(buff_snd)+1);
		close(client_socket);
		close(fd);
	}
}
