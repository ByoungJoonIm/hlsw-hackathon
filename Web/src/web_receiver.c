#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <arpa/inet.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <sys/socket.h>
#include "meta.h"
 
#define BUFSIZE 1024
#define SENDINGUNIT 1000

/*
 	check program's arguments
 */
void argument_check(int argc){
	if(argc != 2){
		printf("usage : ./server_receiver port_number\n");
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

#ifdef DEBUG
void check_buf(char *buf){
	for(int i=0; i<30; i++)
		printf("%c\n", buf[i]);
}
#endif

void receive_message(META * meta_data, int client_socket){
#ifdef DEBUG
	int i = 0;
#endif
	int read_size = 0;
	int fd;
	char buff_rcv[BUFSIZE];
	char file_name[BUFSIZE];

	strcpy(file_name, meta_data->id);
	strcat(file_name, ".rs");
	fd = open(file_name, O_WRONLY | O_CREAT | O_TRUNC, 0644);

	while(1){	//blocked here
		memset(buff_rcv, 0x00, BUFSIZE);
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
	}
	close(fd);
}

#ifdef DEBUG
void send_message(int *client_socket){
	char buff_snd[BUFSIZE];

	sprintf(buff_snd, "server ack\n");	//this message will change to compile message
	write(*client_socket, buff_snd, strlen(buff_snd)+1);
}
#endif

void get_meta(META * meta_data, int client_socket){
	char buff_rcv[BUFSIZE];

	memset(buff_rcv, 0x00, BUFSIZE);
	read(client_socket, buff_rcv, SENDINGUNIT);
	memcpy(meta_data, buff_rcv, sizeof(META));

#ifdef DEBUG
	check_buf(buff_rcv);
	printf("meta_data->request_number : %d\n", meta_data->request_number);
	printf("meta_data->id : %s\n", meta_data->id);
	printf("meta_data->subject_id : %d\n", meta_data->subject_id);
	printf("meta_data->assginment_id : %d\n", meta_data->assignment_id);
#endif
}


int main(int argc, char *argv[]){
	int server_socket;
	int client_socket;
	struct sockaddr_in server_addr;
	struct sockaddr_in client_addr;
	META meta_data;

	argument_check(argc);
	socket_create(&server_socket);
	binding(&server_addr, argv[1], server_socket);

	listen_mode(server_socket);

	while(1){
		client_connect(&client_socket, server_socket, &client_addr);
		get_meta(&meta_data, client_socket);
		receive_message(&meta_data,client_socket);
#ifdef DEBUG
		send_message(&client_socket);
#endif
		close(client_socket);
	}
}
