// Travis Johnson
// 1129181
// Project 1 Computer Networks

/*
This is a client that allow mutliple message to send to a provided server as a host.
from the  client_lecture code with some modification to allow multiple connections to the same host.
*/
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h>
#include <string.h>
#include <stdbool.h>

void error(const char *msg) {
	perror(msg);
	exit(0);
}

int main(int argc, char *argv[]) {
	int sockfd, portno, n;
	struct sockaddr_in   serv_addr;
	struct hostent *server;
	bool running = false; // Keep running until the user types EXIT

    // gcc client.c -o client
    // ./client localhost port
	char buffer[256];
	if (argc <3) {
		fprintf(stderr, "usage %s hostname port\n", argv[0]);
		exit(0);
	}
	portno =  atoi(argv[2]);
	sockfd = socket(AF_INET, SOCK_STREAM, 0);
	
	if(sockfd <0)
		error("ERROR opening socket");
	
	
	server = gethostbyname(argv[1]);
	if (server == NULL) {
		fprintf(stderr, "ERROR , no such host \n");
		exit(0);
	}

	bzero((char *) &serv_addr, sizeof(serv_addr));
	serv_addr.sin_family = AF_INET;
	bcopy((char *) server->h_addr, (char *) &serv_addr.sin_addr.s_addr, server->h_length);
	serv_addr.sin_port = htons(portno);
	if (connect(sockfd, (struct sockaddr *) &serv_addr, sizeof(serv_addr)) <0)
		error("ERROR Connecting");
	while(!running) {
		printf("Please Enter The message: ");
		bzero(buffer, 256);
		fgets(buffer, 255, stdin);
		n = write(sockfd, buffer, strlen(buffer));
		if(n<0)
			error("ERROR writing from socket");
		
		if(strcmp(buffer, "EXIT\n")== 0)
		{
			running = true;
			break;
		}
		bzero(buffer,256);
		n = read(sockfd, buffer,255);
		if(n < 0)
			printf("ERROR reading from  socket");
		printf("%s\n", buffer);
		
	}
	close(sockfd);

	return 0;
}
	
