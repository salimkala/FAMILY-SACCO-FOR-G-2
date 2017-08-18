#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include<sys/socket.h>
#include<sys/types.h>
#include<arpa/inet.h>
#include<netinet/in.h>
#include<netdb.h>
#include<unistd.h>
#include<errno.h>

char hold[]= "Welcome Back";

int main(int argc , char *argv[])
{
    int client;
    struct sockaddr_in server;
    
    //create socket
    client = socket(AF_INET,SOCK_STREAM,0);

    memset(&server,'0',sizeof(server));
    server.sin_family = AF_INET;
    server.sin_port = htons(8888);
    server.sin_addr.s_addr = htonl(INADDR_ANY);
    
           
    //connect to the server
    connect(client, (struct sockaddr *)&server, sizeof(server));
    printf("Connected to the server\n");
    
    char password[100],username[100];
    char message[1000],message1[10000];
    char  receive[1000];
    int i=1,b;
    
    do
    {
		//insert Username and Password	
    bzero(message,1000);
    printf("Enter username:");
    scanf(" %s",username);
    send(client,username,sizeof(username),0);


    printf("\nEnter password:");
    bzero(password,20);
    scanf(" %s",password);
    send(client,password,sizeof(password),0);

    recv(client, message, sizeof(message),0);

    b=strcmp(hold,message);
    
    }
    while(b!=0);
    
    do
    {
	printf("Please follow the formats of submissions displayed below.\n\ncontribution amount date person_name receipt_number\n\nloan request amount\n\nidea name capital description\n\ncontribution check\n\nbenefits check\n\nloan repayment details\n\nPress ctrl + z to exit\n\nEnter command to proceed:");
    bzero(message1,10000);
    
    fgets(message1,10000,stdin);
    send(client,message1,sizeof(message1),0);
    
    bzero(receive,1000);
    recv(client, receive, 1000,0);
    printf("%s",receive);

    }
    while(i!=0);
    
    return 0;

}
