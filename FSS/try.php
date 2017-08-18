<?php

require_once("functions.php");
$c=mysql_connect("localhost","root","");
if(!$c){
	echo mysql_error(); exit();
}
$db=mysql_select_db("familysacco");
if(!$db){
	echo mysql_error(); exit();
}
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$act=$_REQUEST['action'];

?>
<head>
</head>

<h1 style="text-align: center; font-size: 50px;">FAMILY SACCO </h1>
<a href="try.php?action=login" style="text-decoration: none;">Login</a><br>

<table border=0>
<tr>
	
<td>
 <?php
 switch ($act) {
       	case 'login':
       		login();
       		break;

       	case 'sign_in':
        	Admin_Login();
        	break;
       

	    case'loan':
        	loan();
       		break;

       	case'idea':
        	Investment_Idea();
       		break;


        case'reg':
            register();
            break;
        case 'save':
        	NewMember();
        	break;
        case 'profit':
        	profit();
        	break;

        case 'regular':
        	regularmember();
        	break; 

        case 'member':
        	saccomembers();
        	break; 
        case 'loanRepay':
        	loanrepayment();
        	break;

        case 'loanDenied':
        	Deniedloan();
        	break;

        case 'returns':
        	investmentReturns();
        	break;

        case 'benefits':
        	benefits();
        	break;
        case 'pending':
            pending();
            break;
        case 'cut':
            cut();
            break;
            
         case 'memberl':
            regular();
            break;
         case 'benefit':
            benefit();
            break; 
            case 'return':
            investmentReturn();
            break;
          case 'loanDeny':
          Denyloan();
          break;
          
          case 'Repay':
          Repayment();
          break;     
       }   

?>
</td>


</tr>



</table>
