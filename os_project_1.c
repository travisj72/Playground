#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

int main(int argc, char *argv[]) {
    int numchild;
    int fd[2*numchild][2]; // Parent + Child pipe
    int i, j, len, fpos=0, val, count=0, total=0;
    pid_t pid;
    int nums = 1000;
    FILE * file;

    printf("How many children to use: ");
    scanf("%d", &numchild);
    printf("\nWill use %d child process(es).\n", numchild);

    // Create pipes for children
    for (i=0; i<2*numchild; i++){
        pipe(fd[i]);
    }

    for (i=0; i<numchild; i++) {
        if((pid = fork()) == 0) { // Child Processes
            pid = getpid();

            // Read from the parent
            len = read(fd[i][0], &fpos, sizeof(fpos));
            if (len > 0) {
                file = fopen("file1.dat", "r");
                fseek (file, fpos, SEEK_SET);
                count = 0;
                total = 0;

                printf("Child(%d): Recieved position: %d\n", pid, fpos);

                // Read from file starting at fpos
                // Add values read to a total value
                while (count < (nums/numchild)) {
                    fscanf(file, "%i", &val);
                    total += val;
                    count++;
                }
                // Write to parent
                write(fd[i+numchild][1], &total, sizeof(total));
                printf("Child(%d): Sent %d to parent.\n", pid, total);
            } else {
                printf("Child(%d): Error with len\n", pid);
            }

            exit(0);
        }

        // Parent process
        pid = getpid();

        fpos = ((i*nums*5)/numchild); // 5 is the offset of the file values

        // Write to child process
        printf("Parent(%d): Sending file position to child\n", pid);
        write(fd[i][1], &fpos, sizeof(fpos));

        // Wait for child responce
        len = read(fd[i+numchild][0], &total, sizeof(total));
        if (len > 0) {
            printf("Parent(%d): Recieved %d from child.\n", pid, total);
            total += total;
            printf("Parent(%d): Total: %d\n", pid, total);
        } else {
            printf("Parent(%d): Error with len\n", pid);
        }
    }
}
