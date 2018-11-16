#include <stdio.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <string.h>
#include <unistd.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include "meta.h"

#define BUFSIZE 1024
#define SENDINGUNIT 1000
 
int main(int argc, char **argv) {
        struct sockaddr_in serveraddr;
        int server_sockfd;
        int client_len;
        char buf[BUFSIZE];
		int fd;

		if(argc != 4){
			printf("usage : ./client ip port file_name\n");
			return -1;
		}

		/*
		 	open file
		 */
		fd = open(argv[3], O_RDONLY);

		if(fd == -1){
			printf("file open error!\n");
			return -1;
		}


		/*
		 	socket
		 */
		if((server_sockfd = socket(AF_INET, SOCK_STREAM, 0)) == -1) {
			perror("error : ");
			return 1;
		}
		serveraddr.sin_family = AF_INET;
		serveraddr.sin_addr.s_addr = inet_addr(argv[1]);
		serveraddr.sin_port = htons(atoi(argv[2]));

        client_len = sizeof(serveraddr);
 
        if(connect(server_sockfd, (struct sockaddr*)&serveraddr, client_len) == -1) {
                perror("connect error : ");
                return 1;
        }

		/*
		 	write something
		 */
		//파일명을 먼저 전송(서버에 저장될 파일명 / 덮어쓰기됨)
		memset(buf, 0x00, BUFSIZE);
		sprintf(buf, "20165157");
		write(server_sockfd, buf, SENDINGUNIT);

		//현재는 파일을 열어서 그 내용을 다시 전송버퍼로 넘기는 방식
		int read_size;
		while(1){
			read_size = read(fd, buf, SENDINGUNIT);

			if(read_size == 0){
				printf("%d\n", read_size);
				printf("finished file!\n");
				break;
			}

			if(write(server_sockfd, buf, SENDINGUNIT) <= 0) {
				perror("write error : ");
                	return 1;
        	}
			memset(buf, 0x00, BUFSIZE);

		}

		//전송이 완료되면 EOF를 전송
		memset(buf, 0xff, 4);
		write(server_sockfd, buf, SENDINGUNIT);

		/*
		 	read something
		 */

        if(read(server_sockfd, buf, SENDINGUNIT) <= 0) {
                perror("read error: ");
                return 1;
        }
        close(server_sockfd);
        printf("[server]\n%s", buf);

		close(fd);

        return 0;
}

