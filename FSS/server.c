#include<stdio.h>
#include<string.h>
#include<sys/types.h>
#include<sys/socket.h>
#include<arpa/inet.h>
#include<netinet/in.h>
#include<stdlib.h>
#include<errno.h>
#include<time.h>
#include<mysql/mysql.h>

char *login(char x[],char y[]);
char *retrieve(char *select);

static char *host = "localhost";
static char *user = "root";
static char *pass  = "";
static char *dbname = "SACCO";
unsigned int port = 3306;
static char *unix_socket = NULL;
unsigned int flag = 0;

char username[20],password[20]; 
char *hold= "Welcome Back";


int main(int argc, char *argv[])
{
    int socketstream=0, client;
    struct sockaddr_in server, clienti;
    
    char message1[1000];
    char message2[1000]="Message Received\n";
    
    //socket creation
    socketstream = socket(AF_INET,SOCK_STREAM,0);
    
    //socket structure
    bzero(&server,sizeof(server));
    server.sin_addr.s_addr = htonl(INADDR_ANY);
    server.sin_family = AF_INET;
    server.sin_port = htons(5000);
    
    //Assigning port and ip
    bind(socketstream, (struct sockaddr *)&server, sizeof(server));
    puts("bind done\n");
    //listen
    listen(socketstream, 10);

    while (1) 
    {
		
    int sizeofclient= sizeof(clienti);  
    client= accept(socketstream,(struct sockaddr*) &clienti, &sizeofclient);
    
    //Reception of Login details
    char *reply ;
    int select;
    
    bzero(username,20);
    bzero(password,20);
    
    do
    {
    recv(client, username, sizeof(username),0);
    printf("%s\n",username);
    
    recv(client, password, sizeof(password),0);
    printf("%s\n",password);
    
    reply= login(username,password);
    printf("%s\n",reply);
    
    
    send(client,reply,1000,0);
    
    select=strcmp(hold,reply);
    
    }
    while(select!=0);
    
   do{
    recv(client, message1, sizeof(message1),0);

	int MemberID;
	MemberID =obtainid(username,password);
	
	printf("%d",MemberID);
	
	MYSQL *connect = mysql_init(NULL);
  
    if(!mysql_real_connect(connect,host,user,pass,dbname,port,unix_socket,flag)){
  
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
  } 
	//contribution check
	if(strcmp(message1,"contribution check")==0)
	{
	char holdquery2[1000];
    sprintf(holdquery2, "select * from MemberContributions where MemberID= %d",MemberID);
     if (mysql_query(connect, holdquery2)) {
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
   }

    MYSQL_RES *result = mysql_use_result(connect);
	MYSQL_ROW row= mysql_fetch_row(result);
	
	char *holdmessage=row[0];
	send(client, &holdmessage, sizeof(&holdmessage),0);
	
	mysql_free_result(result);
    mysql_close(connect);
	
	}
	//benefits check
	if(strcmp(message1,"benefits check")==0)
	{
	char holdquery2[1000];
    sprintf(holdquery2, "select * from memberbenefits where MemberID= %d",MemberID);
     if (mysql_query(connect, holdquery2)) {
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
   }

    MYSQL_RES *result= mysql_use_result(connect);
	MYSQL_ROW row= mysql_fetch_row(result);
	
	char *holdmessage=row[1];
	send(client, &holdmessage, sizeof(&holdmessage),0);
	
	mysql_free_result(result);
	mysql_close(connect);
	
	}
	//loan repayment
	if(strcmp(message1,"loan repayment")==0)
	{
	char holdquery2[1000];
    sprintf(holdquery2, "select * from loanrepayment where MemberID= %d",MemberID);
     if (mysql_query(connect, holdquery2)) {
      fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
   }

    MYSQL_RES *result= mysql_use_result(connect);
	MYSQL_ROW row;
	
	if((row= mysql_fetch_row(result))!=NULL) {
		
	char *holdmessage=row[3];
	send(client, &holdmessage, sizeof(&holdmessage),0);
	
	mysql_free_result(result);
	mysql_close(connect);
}
	
	}

    else
    {
		//file creation and writing
    FILE *fp;
    fp = fopen("family_sacco.txt","a");
    fprintf(fp,"%s \n",message1);
    printf("Data written to the file\n");
    fclose(fp);
    
	send(client,message2,sizeof(message2),0);
    
    }
    }
    while(message1!=0);
    }
    
    
    return 0;
}

char * login(char user[],char pass[]){
    MYSQL *connect = mysql_init(NULL);
  
  if (connect == NULL)
  {
      fprintf(stderr, "mysql_init() failed\n");
      exit(1);
  }  
  
  if(!mysql_real_connect(connect,host,user,pass,dbname,port,unix_socket,flag)){
  
          fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
  }    
  
  if (mysql_query(connect, "SELECT * FROM member")) 
  {
           fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
  }
  
  MYSQL_RES *result = mysql_store_result(connect);
  
  if (result == NULL) 
  {
           fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
  }

  int num_fields = mysql_num_fields(result);

  MYSQL_ROW row;
  
  while ((row = mysql_fetch_row(result))) 
  { 
      for(int i = 0; i < num_fields; i++)
 
      { char *a = row[i] ? row[i] : "NULL";
    if(strcmp(user,a)==0){
         for(int j = 0; j < num_fields; j++)
                   
      { char *b = row[j] ? row[j] : "NULL";
               if(strcmp(pass,b)==0){ if(i<j){

          
        return "Welcome Back";
        }
     } 
  }
         }
      } 
       
  }
  
  mysql_free_result(result);
  mysql_close(connect);
  return "Incorrect Username or Password";
  exit(0);
}

int obtainid(char username[], char password[])
{
    int MemberID;
    char holdquery[2000];
    
    MYSQL *connect = mysql_init(NULL);
  
    if(!mysql_real_connect(connect,host,user,pass,dbname,port,unix_socket,flag)){
  
       fprintf(stderr, "%s\n", mysql_error(connect));
      exit(1);
  } 
    
    sprintf(holdquery, "select * from member where Username = '%s' and Password = '%s'",username, password);
   
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


