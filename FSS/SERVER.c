#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include<sys/types.h>
#include<sys/socket.h>
#include<unistd.h>
#include<arpa/inet.h>
#include<netinet/in.h>
#include<errno.h>
#include<mysql/mysql.h>

static char *host="localhost";
static char *user="root";
static char *pass="";
static char *dbname="SACCO";
static char *unix_socket=NULL;
unsigned int port=3306;
unsigned int flag=0;

char *login(char username[],char password[]);
char hold[]="Welcome Back";

int main(int argc , char *argv[])
{  
	int socketstream;
    
    char username[100],password[100];
 
    struct sockaddr_in server, client;
     
    //socket creation
    socketstream = socket(AF_INET,SOCK_STREAM,0);
    
    bzero(&server,sizeof(server));
	
	//socket structure
    server.sin_family = AF_INET;
    server.sin_port = htons(8888);
    server.sin_addr.s_addr = INADDR_ANY;
    
	//Assigning port and ip
    bind(socketstream, (struct sockaddr *)&server, sizeof(server));
    
    //listen for clients
	listen(socketstream, 10);
	   puts("Waiting for clients\n");

    while(1) {
		
    int sizeclient = sizeof(client);  
    int clienti = accept(socketstream,(struct sockaddr*) &client, &sizeclient);

    puts("Port open for connections\n");
    
    //Recieve login details from clients

	
	char message1[1000];
	bzero(message1,1000);
	recv(clienti, message1, sizeof(message1),0);
	
	int MemberID;
	MemberID =ID(username,password);
	
	MYSQL *connect = mysql_init(NULL);
  
    if(!mysql_real_connect(connect,host,user,pass,dbname,port,unix_socket,flag)){
  
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
  } 
	
	if(strcmp(message1,"contribution check")==0)
	{
	char holdquery2[1000];
    sprintf(holdquery2, "select * from Contributions where MemberID= %d",MemberID);
     if (mysql_query(connect, holdquery2)) {
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
   }

    MYSQL_RES *result = mysql_use_result(connect);
	MYSQL_ROW row= mysql_fetch_row(result);
	
	char *holdmessage=row[0];
	send(clienti, &holdmessage, sizeof(&holdmessage),0);
	
	mysql_free_result(result);
    mysql_close(connect);
	
	}
	
	if(strcmp(message1,"benefits check")==0)
	{
	char holdquery2[1000];
    sprintf(holdquery2, "select * from MemberBenfits where MemberID= %d",MemberID);
     if (mysql_query(connect, holdquery2)) {
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
   }

    MYSQL_RES *result= mysql_use_result(connect);
	MYSQL_ROW row= mysql_fetch_row(result);
	
	char *holdmessage=row[1];
	send(clienti, &holdmessage, sizeof(&holdmessage),0);
	
	mysql_free_result(result);
	mysql_close(connect);
	
	}
	
	if(strcmp(message1,"loan repayment")==0)
	{
	char holdquery2[1000];
    sprintf(holdquery2, "select * from LoanRepayment where MemberID= %d",MemberID);
     if (mysql_query(connect, holdquery2)) {
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
   }

    MYSQL_RES *result= mysql_use_result(connect);
	MYSQL_ROW row;
	
	if((row= mysql_fetch_row(result))!=NULL) {
		
	char *holdmessage=row[3];
	send(clienti, &holdmessage, sizeof(&holdmessage),0);
	
	mysql_free_result(result);
	mysql_close(connect);
}
	
	}
	
	else {
	
	//file creation and writing
	FILE *fp;
	fp=fopen("family_sacco.txt","a");
	printf("Data saved to file");
	fprintf(fp,"%s\t%d\n", message1,MemberID);
	fclose(fp);
		
	}
 
}
    return 0;
}


char *login(char username[],char password[]){
    MYSQL *connect = mysql_init(NULL);
  
  if(!mysql_real_connect(connect,host,user,pass,dbname,port,unix_socket,flag)){
  
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
  }    
  
  mysql_query(connect, "SELECT * FROM Member"); 
  
  MYSQL_RES *result = mysql_store_result(connect);

  int fieldcount = mysql_num_fields(result);

  MYSQL_ROW row;
  
  while ((row = mysql_fetch_row(result))) 
  { 
      for(int i = 0; i < fieldcount; i++)
 
      { char *a = row[i] ? row[i] : "NULL";
    if(strcmp(username,a)==0){
         for(int j = 0; j < fieldcount; j++)
                   
      { char *b = row[j] ? row[j] : "NULL";
               if(strcmp(password,b)==0){ if(i<j){

        return "Welcome";
        
 }
 } 
 }
 }
 }     
  }
  
  mysql_free_result(result);
  mysql_close(connect);
  return "Incorrect Username and Password.Try again";
  exit(0);
}

int ID(char username[], char password[])
{
    int MemberID;
    char holdquery[2000];
    
    MYSQL *connect = mysql_init(NULL);
  
    if(!mysql_real_connect(connect,host,user,pass,dbname,port,unix_socket,flag)){
  
       fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
  } 
    
    sprintf(holdquery, "select * from Member where MemberUsername = '%s' and MemberPassword = '%s'",username, password);
   
   if (mysql_query(connect, holdquery)) {
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
   }

   MYSQL_RES *result = mysql_use_result(connect);
   
   MYSQL_ROW row;

   if ((row = mysql_fetch_row(result)) != NULL){
      MemberID = atoi(row[0]); 
   }
   
   mysql_free_result(result);
   mysql_close(connect);
   
   return MemberID;
}
