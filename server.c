/*
socketlen_t is a type that is used to declare a variable that can hold the length of a socket address, which itself is variable depending on the address family. 
It isn't that length itself/*
This server allow  multiple connection through a
specified port. This code has been adapted from the tutorial
server_lecture on blackboard.
*/

#include <stdio.h>
#include <stdlib.h>			// for IOs
#include <string.h> 
#include <unistd.h>
#include <sys/types.h> 			// for system calls
#include <sys/socket.h> 		// for sockets
#include <netinet/in.h>			// for internet 
#include <stdbool.h>
#include <pthread.h>			// for thread;

/* a function to print out error message and then abort */
void error(const char *msg) {
	perror(msg);
	exit(1);
}

void *threadFunct(void *arg) {
    int mySockfd;
	char buffer2[256];	
	bool exit = false;
	int read_writeLen;
    mySockfd = *((int *)arg);
	while(!exit) {
		bzero(buffer2, 256);
 		read_writeLen = read(mySockfd, buffer2, 255);
		if (read_writeLen < 0)
			printf("ERROR reading from the client socket\n");
		
		if(strcmp(buffer2,"EXIT\n")==0) {
			printf("Now socket %d will be close\n", mySockfd);
			close(mySockfd);
			pthread_exit(NULL); 	// terminate the calling thread
		
		} else {
			printf("The message read from socket %d :%s\n ",mySockfd,buffer2);
			read_writeLen = write(mySockfd,"I got Your Message!" , 19);
			if (read_writeLen < 0)
				printf("Unable to write to socket\n");
		}
	}
	close(mySockfd);
	return  NULL;

}
int main(int argc, char *argv[]) {
	int sockfd, newsockfd, portno;
	socklen_t clilen;
	char buffer[256];
	struct sockaddr_in serv_addr, cli_addr;
	int charRead_Written;
	if(argc <2) {
		fprintf(stderr, "ERROR, no port provided\n");
		exit(1);
	}
	
	sockfd = socket(AF_INET, SOCK_STREAM, 0);
	if(sockfd < 0)
		error("ERROR Opening socket");
	
	bzero((char *) &serv_addr, sizeof(serv_addr));
	portno = atoi(argv[1]);			
	serv_addr.sin_family = AF_INET;
	serv_addr.sin_addr.s_addr = INADDR_ANY;
	serv_addr.sin_port = htons(portno);
	
	if(bind(sockfd,(struct sockaddr *) &serv_addr, sizeof(serv_addr)) < 0)
		error("ERROR on binding");
	
	
	while(true) {
		pthread_t  threadId;
		listen(sockfd,10);
		clilen = sizeof(cli_addr);
		newsockfd = accept(sockfd, (struct sockaddr *) &cli_addr, &clilen);
		if(newsockfd<0)
			error("ERROR on accept");
	    pthread_create(&threadId, NULL, threadFunct, &newsockfd);
	}

	close(sockfd);
	return 0;
}