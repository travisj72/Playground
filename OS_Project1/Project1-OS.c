#include <stdio.h> 
#include <stdlib.h>

int main(void) {
    int num_processes;
    int running = 1;
    do {
        printf ("How many processes do you want? (1, 2 or 4) \n");
        do {
            num_processes = getchar();
        } while(num_processes == '\n');  
        num_processes -= '0';

        if(num_processes == 1 || num_processes == 2 || num_processes == 4){
            int temp = num_processes - 1;
            printf("\n1 Parent and %d child processes\n", temp);
            printf("----------------------------------\n");
            running = 0;
        } else {
            printf("Invalid Input, please try again.\n");
        }
    } while(running == 1);

    // Open File
    FILE *fptr;
    fptr = fopen("C:\\Users\\Travis Johnson\\Desktop\\program.txt","w"); // Pass in File here
    if(fptr == NULL)
    {
        printf("Error!");   
        exit(1);             
    }

    fclose(fptr);
    return(0);
}
