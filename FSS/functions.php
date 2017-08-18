<?php
function register(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
  <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>FAMILY SACCO</title>
  <style>
  .reports{
				margin-left:500px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:500px;
				
			}
		.but {
			width:150px;
			color: black;
			background-color: green;
			border: none;
			height: 30px;
			border-radius: 4px;
		}
		
		b1 {
			width: 150px;
			heigth:35px;
		}
			
			
  </style>
  </head>
  <body>
	  <div class="reports">
    <h1 id="h1">
      FAMILY SACCO
    </h1>
    
    <h3 id="h2">NEW MEMBER REGISTRATION FORM</h3>
    
    <FORM method='POST' action='try.php?action=save' id="form">
		
      <label class="l1">Member Date<br><input type="date" class="b1" name="dat"></label><br><br>
      
      <label class="l1">Last name<br><input type="text" class="b1" name="ln"></label><br><br>
      <label class="l1">Username<br><input type="text" class="b1" name="user"></label><br><br>
      <label class="l1">Password<br><input type="password" class="b1" name="pass"></label><br><br>
      <label class="l1">Contribution<br><input type="number" class="b1" name="contr"></label><br><br>
      <label class="l1">MemberID<br><input type="number" class="b1" name="Id"></label><br><br>
      <label class="l1">Receipt Number<br><input type="number" class="b1" name="Receipt"></label><br><br>
      <input type="submit" value="Submit" id="s1" class="but">
      <input type="reset" value="Clear" id="s2" class="but">
    </FORM>
    </div>
  </body> 
  
</html>


<?php
return adminpage();
}

function NewMember() {
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
$u=$_POST['contr'];	
$z=date('Y-m-d',strtotime($_POST['dat']));
$g=$_POST['fn'];
$h=$_POST['ln'];
$j=$_POST['user'];
$k=$_POST['pass'];
$u=$_POST['contr'];
$y=$_POST['Id'];
$a=$_POST['Receipt'];
	
$m="select sum(ContributionAmount) from MemberContributions,member where MemberContributions.MemberID=member.MemberID ";
  
$n=mysql_query($m);

$l=mysql_num_rows($n);

for ($i=0; $i < $l; $i++)
 {
    
    $k=mysql_fetch_row($n);
    $k[0];
    $total[$i]=$k[0];
    
  }

$maxi=max($total);


if($u>=(0.75*$maxi)){

$mmm="insert into member(MemberID,Person_Name,Username,Password,EntryDate) values($y,'$h','$j','$k','$z')";
$nnn=mysql_query($mmm);

$mm="insert into MemberContributions(PersonName,ContributionAmount,ContributionDate,ReceiptNo,MemberID) values('$h',$u,'$z',$a,$y)";
$nn=mysql_query($mm);
       
       }
       return adminpage();
     }

function loan() {
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
$b = time();

$b = date('Y-m-d',$b)."</br>";
echo $c = date('Y-m-d',strtotime('- 1 month'))."</br>";
echo $dd= date('Y-m-d',strtotime('- 2 month'))."</br>";
echo $ee = date('Y-m-d',strtotime('- 3 month'))."</br>";
echo $ff = date('Y-m-d',strtotime('- 4 month'))."</br>";
echo  $gg = date('Y-m-d',strtotime('- 5 month'))."</br>";
echo  $hh = date('Y-m-d',strtotime('- 6 month'))."</br>";


$fy="select LoanAmount,LoanID,MemberID from LoanRequest order by LoanID DESC limit 1";
$fz=mysql_query($fy);
while ($fyy=mysql_fetch_assoc($fz)) {
	$fzz=$fyy['LoanAmount'];
	$fzzz=$fyy['MemberID'];
	$LoanID=$fyy['LoanID'];
	echo"<tr><td>".$fyy['LoanID']."</td></tr></br>";
}
     
$lp="select MemberID from member";
$le="select count(MemberID) from member";
$lf=mysql_query($le);
while ($lg=mysql_fetch_assoc($lf)) {
	$lh=$lg['count(MemberID)'];

	
}
$lq=mysql_query($lp);
$ld=mysql_num_rows($lq);
for ($li=0; $li < $ld; $li++) 
     {
  
 $lk=mysql_fetch_row($lq);
 $lk[0];
 
 $totalID[$li]=$lk[0];
 
 
      }
 
      $lz=0;
      while($lz<$lh)
     {	
   if($totalID[$lz]==$fzzz){
$f="select ContributionAmount,count(ContributionAmount) as times1 from MemberContributions where ContributionDate between '$c' and '$b' && MemberID='$totalID[$lz]' group by PersonName ";
$g=mysql_query($f);

while ($h=mysql_fetch_assoc($g)) {
	$j=$h['times1'];
	echo"<tr><td>".$h['times1']."</td></tr></br>";
}
if($j>=1){
$k="select ContributionAmount,count(ContributionAmount) as times2 from MemberContributions where ContributionDate between '$dd' and '$c' && MemberID='$totalID[$lz]' group by PersonName";
$l=mysql_query($k); 
 while ($m=mysql_fetch_assoc($l)) {
	$n=$m['times2'];
	echo"<tr><td>".$m['times2']."</td></tr></br>";
}

if($n>=1){
$o="select ContributionAmount,count(ContributionAmount) as times3 from MemberContributions where ContributionDate  between '$ee' and '$dd' && MemberID='$totalID[$lz]' group by PersonName";
$p=mysql_query($o); 
 while ($q=mysql_fetch_assoc($p)) {
	$r=$q['times3'];
	echo"<tr><td>".$q['times3']."</td></tr></br>";	
}
if($r>=1){
$s="select ContributionAmount,count(ContributionAmount) as times4 from MemberContributions where ContributionDate  between '$ff' and '$ee' && MemberID='$totalID[$lz]' group by PersonName";
$t=mysql_query($s); 
 while ($v=mysql_fetch_assoc($t)) {
	$u=$v['times4'];
	echo"<tr><td>".$v['times4']."</td></tr></br>";	
}
if($u>=1){
$w="select ContributionAmount,count(ContributionAmount) as times5 from MemberContributions where ContributionDate between '$gg' and '$ff' && MemberID='$totalID[$lz]' group by PersonName";
$x=mysql_query($w); 
 while ($y=mysql_fetch_assoc($x)) {
	$z=$y['times5'];
	echo"<tr><td>".$y['times5']."</td></tr></br>";	
}
if($z>=1){
$aa="select ContributionAmount,count(ContributionAmount) as times6 from MemberContributions where ContributionDate between '$hh' and '$gg' && MemberID='$totalID[$lz]' group by PersonName";
$bb=mysql_query($aa); 
 while ($cc=mysql_fetch_assoc($bb)) {
	$dd=$cc['times6'];

	echo"<tr><td>".$cc['times6']."</td></tr></br>";	
}
if($dd>=1)
      {  
	
$jj="select sum(ContributionAmount) as Total,PersonName from MemberContributions where MemberID='$totalID[$lz]' group by PersonName";
$kk=mysql_query($jj);
	
while ($ll=mysql_fetch_assoc($kk))
     {
$mm=$ll['Total'];
$regular=$ll['PersonName'];
echo "$regular</br>";	
		$regu="insert into regularmember values('$fzzz','$regular')";
		$reguquery=mysql_query($regu);
      }

if($fzz<=(0.5*$mm))
{
 
 $fb= $fzz*0.03*1;
 $fc=$fb+$fzz;
 echo "$fc</br>";
 $loanRepaymet="insert into loanrepayment (RepaymentAmount,Interest,LoanID,MemberID) values ('$fc','$fb','$LoanID','$fzzz')";
 $RepymentInsert=mysql_query($loanRepaymet);
}

}
}
}
}
}
}
else
{
$loanDenied="insert into  DeniedLoan (MemberID,LoanID) values('$fzzz','$LoanID')";
$LoanQuery=mysql_query($loanDenied);

}
}
$lz++;

}
return adminpage();
}

function Investment_Idea(){

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
		.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
    </style>
 
  </head>
  <body>
	  <div class="reports">
    <h1 id="h1">
      FAMILY SACCO
    </h1>
    
    <h3 id="h2"> INVESTMENT IDEA</h3>
    <FORM method='POST' action='try.php?action=profit' id="form">

      <label class="l1">Business Name<br><input type="text" class="b1" name="busines"></label><br><br>   
      <label class="l1">Final Price<br><input type="number" class="b1" name="finalprice"></label><br><br>
      <label class="l1">Investment ID<br><input type="number" class="b1" name="invest"></label><br><br>
      <label class="l1">idea ID<br><input type="number" class="b1" name="idea"></label><br><br>
      <input type="submit" value="Submit" id="s1" class="but">
      <input type="reset" value="Clear" id="s2" class="but">
    </FORM>
    </div>
  </body> 
</html>
    
<?php
return adminpage();
}
 function profit(){  
	 error_reporting(E_ERROR | E_WARNING | E_PARSE);
  $finalprice=$_POST['finalprice'];
  $invest=$_POST['invest'];
  $idea=$_POST['idea'];
  $business=$_POST['busines'];
  

 
     
   $Investment_Date="select Investment_Date from BusinessFollowUp where Investment_ID='$invest'";
  $u=mysql_query($Investment_Date);
  
  
  while ($tt=mysql_fetch_assoc($u)) 
      {
 
 
  $store6=
  $store6=$tt['Investment_Date'];
 
  
      }
      $m="select entrydate from member";
      $n=mysql_query($m);

      $l=mysql_num_rows($n);

      
      for ($i=0; $i < $l; $i++) 
     {
  
 $lk=mysql_fetch_row($n);
 $lk[0];
 
 

 
 $totalID[$i]=$lk[0];
 
 
 
      }

   
  $r="select InitialPrice from pendingidea where  idea_ID='$idea'";
	$s=mysql_query($r);
    while ($h=mysql_fetch_assoc($s)) 
      {
 
  $store1=$h['InitialPrice'];
  
}
  $e= $finalprice-$store1;
  
  $returns="insert into investmentreturns values('$e','$invest','$business')";
  $QueryReturns=mysql_query($returns);
   
  if($e>=1) 
      {

  	
  $f=0.3*$e;
  
  $insertsaving="insert into savings values($invest,$f)";
  $insertsavingquery=mysql_query($insertsaving);
  
  $w=0.65*$e;
 
 
      
       $fd="select sum(ContributionAmount)  from MemberContributions where ContributionDate between '$min' and '$store6'";
$fe=mysql_query($fd);

while ($ff=mysql_fetch_assoc($fe)) 
      {
 
      $store4=$ff['sum(ContributionAmount)'];
  

      }
 



 $m="select ContributionAmount,sum(ContributionAmount) as tot,MemberID from MemberContributions where ContributionDate between '$min' and '$store6' group by MemberID";
      $n=mysql_query($m);

      $l=mysql_num_rows($n);

      
      for ($i=0; $i < $l; $i++) 
     {
  
 $lk=mysql_fetch_row($n);

 $lk[1];
 $lk[2];
 
 
 $totalID[$i]=$lk[1];
 $total[$i]=$lk[2];

 $bene[$i]=($totalID[$i]/$store4)*$w ;
 
 $insertbene="insert into memberbenefits values($total[$i],$bene[$i])";
 $insertbenequery=mysql_query($insertbene);

      }
  



$high=0.05*$e;

$m="select sum(ContributionAmount) from MemberContributions where ContributionDate between '$min' and '$store6' group by MemberID";
$n=mysql_query($m);
$l=mysql_num_rows($n);
for ($i=0; $i < $l; $i++) 
      {
  
 $k=mysql_fetch_row($n);
 $k[0];
 
 $total[$i]=$k[0];
 
 
      }

$maxi=max($total);
echo "the highest amount is $maxi</br>";
$highest=$high+$maxi;



}


else
{
echo"There will be no shares distributed at the end of this business investment because we incurred a loss of".$e. "<br/><br/><br/><br/>";
}
return adminpage();
}

function login(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	?>
	<html>
    <head>
    <meta charset="utf-8">
    <title>FAMILY SACCO</title>
    <style type="text/css">
		body{
			}
			#welcome{
				color:#DC143C;
				margin-left: 400px;
			}
			#password{
				margin-left:400px;
				color:#DC143C;
			}
			#username{
				margin-left:400px;
				color:#DC143C;
			}
			#login{
				border-radius:5px;
				font-size:15px;
				font-weight:bold;
				color:blue;
				padding: 5px 5px;
				margin-left:420px;
				width: 170px;
			}
			.text{
				border-radius: 5px;
				border-width:2px;
				border-color: black;
				width:200px;
				height:40px;
				margin-left:400px;

			}		
    </style>
    </head>
    <body>
          
          <form action='try.php?action=sign_in' method="post">
			  <div id="log">
            <label id="username">Username<br><input type="text" required autocomplete="on" name="user" class="text"></label><br><br>

            <label id="password">Password<br><input type="password" required name="password" class="text"></label><br><br>
            
            <input  id="login"type="submit" value="LOGIN">
				</div>
          </form>
    </body>
    </html>

  <?php
}

function Admin_Login() {
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $username =$_POST['user'];
    $password=$_POST['password'];
    $f=mysql_fetch_assoc(mysql_query("select username,password from member where username='$username' and password='$password'"));
    $fa=mysql_fetch_assoc(mysql_query("select admin_username,admin_password from administrator where admin_password='$password' and admin_username='$username'"));
    if (!$f && !$fa) {
    	return false;
    }
    else if ($f) {
    	memberpage();
    }
    else if ($fa) {
    	adminpage();
    }
}
 
function regularmember(){
$regular="select MemberID,Name From regularmember";
$regular_query=mysql_query($regular);
$rows=mysql_num_rows($regular_query);
?>
<!DOCTYPE html>
<html>
<head>
<style>
.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
</style>
</head>
<body>
	<div class="reports">
<?php
echo "<table border=1>
<tr><th> MEMBER ID</th> <th>FIRST NAME</th></tr>";
?>
<?php
for($i=0;$i<$rows;$i++){
	$regular_array=mysql_fetch_row($regular_query);
	$regular_array[0];
	$regular_array[1];
	$regular_array1=$regular_array[0];
    $regular_array2=$regular_array[1];
    ?>
    
    <td><?php echo $regular_array1;?></td><td><?php echo $regular_array2;?></td>

    <?php
}
?>

</tr>
</table>
</div>
<?php

return adminpage();
}
  
  function saccomembers(){
	  error_reporting(E_ERROR | E_WARNING | E_PARSE);

$member="select Person_Name,MemberID from member";
$member_query=mysql_query($member);
$rows=mysql_num_rows($member_query);
?>
<!DOCTYPE html>
<html>
<head>
<style>
.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
</style>
</head>
<body>
	<div class="reports">
<?php
echo "<table border=1>
<tr><th> PERSON NAME</th> <th>MEMBER ID</th></tr>";
?>
<?php
for($i=0;$i<$rows;$i++){

$member_fetch=mysql_fetch_row($member_query);
$member_fetch[0];
$member_fetch[1];
$member_fetch1=$member_fetch[0];
$member_fetch2=$member_fetch[1];
?>

  
<tr><td><?php echo  $member_fetch1;?></td>
<td><?php echo $member_fetch2;?></td></tr>

<?php
}?>
</table>
</div>
</body>
<?php
return adminpage();
}

function loanRepayment(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
$repay="select RepaymentAmount,Interest,LoanID,MemberID from loanrepayment";
$repay_query=mysql_query($repay);
$rows=mysql_num_rows($repay_query);
?>
<!DOCTYPE html>
<html>
<head>
<style>
.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
</style>
</head>
<body>
	<div class="reports">
<table border=1>
  <tr><th> REPAYMENT AMOUNT</th> <th>INTEREST</th><th>LOAN ID</th><th>MEMBER ID</th></tr>
  <?php
for($i=0;$i<$rows;$i++){
$repay_array=mysql_fetch_row($repay_query);
$repay_array[0];
$repay_array[1];
$repay_array[2];
$repay_array[3];

$repay_array1=$repay_array[0];
$repay_array2=$repay_array[1];
$repay_array3=$repay_array[2];
$repay_array4=$repay_array[3];
?>


<tr>
<td><?php echo $repay_array1; ?></td>
<td><?php echo $repay_array2; ?></td>
<td><?php echo $repay_array3; ?></td>
<td><?php echo $repay_array4; ?></td>
</tr>
<?php
}
?>
</table>
</div>
</body>
<?php
return adminpage();
}

function Deniedloan(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
$deny="select LoanID,MemberID from DeniedLoan";
$deny_query=mysql_query($deny);
$rows=mysql_num_rows($deny_query);?>
<!DOCTYPE html>
<html>
<head>
  <style type="text/css">
	  .reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
  </style>
</head>
<body>
	<div class="reports">
 <table border="1">
<tr><th> LOAN ID</th> <th>MEMBER NAME</th></tr>
<?php
for($i=0;$i<$rows;$i++){
$deny_array=mysql_fetch_row($deny_query);
$deny_array[0];
$deny_array[1];

$deny_array1=$deny_array[0];
$deny_array2=$deny_array[1];

?>

<tr>
<td><?php echo $deny_array1; ?></td>
<td><?php echo $deny_array2; ?></td>
<?php
}
?>
</tr>
</table>
</div>
</body>
<?php
return adminpage();
}

function investmentReturns(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

$idea="select Returns, investment_id,businessname from investmentreturns";
$idea_query=mysql_query($idea);
$rows=mysql_num_rows($idea_query);
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
</style>
</head>
<body>
	<div class="reports">
<?php
echo "<table border=1>
<tr><th> RETURNS</th> <th>INVESTMENT ID</th> <th>BUSINESS NAME</th></tr>";
?>
<?php
for($i=0;$i<$rows;$i++){
$idea_array=mysql_fetch_row($idea_query);
$idea_array[0];
$idea_array[1];
$idea_array[2];
$idea_array1[$i]=$idea_array[0];
$idea_array2[$i]=$idea_array[1];
$idea_array3[$i]=$idea_array[2];
?>
<tr>
	<td> <?php echo $idea_array1[$i]; ?></td>
	<td> <?php echo $idea_array2[$i]; ?></td>
	<td> <?php echo $idea_array3[$i]; ?></td>

<?php
}
?>
</tr>
</table>
</div>
</body>
</html>
<?php
return adminpage();
}

function benefits(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
$benefits="select MemberId, Benefits from memberbenefits";
$benefits_query=mysql_query($benefits);
$rows=mysql_num_rows($benefits_query);
?>
<html>
	
	<head>
		<style type="text/css">
			.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
			
		</style>	
	</head>
	<body>
		<div class="reports">
<table border=1>
  <tr><th> LOAN ID</th> <th>BENEFITS</th></tr>
  <?php
for($i=0;$i<$rows;$i++){

	$benefits_array=mysql_fetch_row($benefits_query);
    $benefits_array[0];
    $benefits_array[1];
    $benefits_array1[$i]=$benefits_array[0];
    $benefits_array2[$i]=$benefits_array[1];
?>


<tr>
<td> <?php echo $benefits_array1[$i];?></td>
<td> <?php echo $benefits_array2[$i];?></td>

<?php


}
?>
</tr>
</table>
</div>
</body>
<?php
return adminpage();
}
function adminpage(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	body a{
		text-decoration:none;
		font-size:30px;
		color:blue;
	}
	
</style></head>
<body>
	
    
    <a href="try.php?action=regular">Regular Member</a><br>
    <a href="try.php?action=member">Sacco Member</a><br>
    <a href="try.php?action=loanRepay">Loan Repayment</a><br>
    <a href="try.php?action=loanDenied">Loan Denied</a><br>
    <a href="try.php?action=returns">Investment Returns</a><br>
    <a href="try.php?action=benefits">Benefits Distribution</a><br>
    <a href="try.php?action=profit">Returns distribution</a><br>
    <a href="try.php?action=idea">Investment Idea</a><br>
    <a href="try.php?action=reg">Register Member</a><br>
    <a href="try.php?action=save">Member Approval</a><br>
    <a href="try.php?action=loan">Loan Approval</a><br>
    <a href="try.php?action=cut">Cut File</a><br>
    <a href="try.php?action=pending">Pending Inputs</a><br>

</body>
</html> 

<?php
}
function memberpage(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
a {
	
	text-decoration: none;
	margin-left: 80px;
	font-size: 20px;
}

</style>

</head>
<body>
  
    
    <a href="try.php?action=memberl">Regular Member</a><br>
    <a href="try.php?action=Repay">Loan Repayment</a><br>
    <a href="try.php?action=loanDeny">Loan Denied</a><br>
    <a href="try.php?action=return">Investment Returns</a><br>
    <a href="try.php?action=benefit">Benefits Distribution</a><br>
    
    
   
    
     
</body>
</html> 
<?php
}
function Repayment(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
$repay="select RepaymentAmount,Interest,LoanID,MemberID from loanrepayment";
$repay_query=mysql_query($repay);
$rows=mysql_num_rows($repay_query);
?>
<!DOCTYPE html>
<html>
<head>
<style>
.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
</style>
</head>
<body>
	<div class="reports">
<table border=1>
  <tr><th> REPAYMENT AMOUNT</th> <th>INTEREST</th><th>LOAN ID</th><th>MEMBER ID</th></tr>
  <?php
for($i=0;$i<$rows;$i++){
$repay_array=mysql_fetch_row($repay_query);
$repay_array[0];
$repay_array[1];
$repay_array[2];
$repay_array[3];

$repay_array1=$repay_array[0];
$repay_array2=$repay_array[1];
$repay_array3=$repay_array[2];
$repay_array4=$repay_array[3];
?>


<tr>
<td><?php echo $repay_array1; ?></td>
<td><?php echo $repay_array2; ?></td>
<td><?php echo $repay_array3; ?></td>
<td><?php echo $repay_array4; ?></td>
</tr>
<?php
}
?>
</table>
</div>
</body>
<?php
return memberpage();
}
function Denyloan(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
$deny="select LoanID,MemberID from DeniedLoan";
$deny_query=mysql_query($deny);
$rows=mysql_num_rows($deny_query);?>
<!DOCTYPE html>
<html>
<head>
  <style type="text/css">
	  .reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
  </style>
</head>
<body>
	<div class="reports">
 <table border="1">
<tr><th> LOAN ID</th> <th>MEMBER NAME</th></tr>
<?php
for($i=0;$i<$rows;$i++){
$deny_array=mysql_fetch_row($deny_query);
$deny_array[0];
$deny_array[1];

$deny_array1=$deny_array[0];
$deny_array2=$deny_array[1];

?>

<tr>
<td><?php echo $deny_array1; ?></td>
<td><?php echo $deny_array2; ?></td>
<?php
}
?>
</tr>
</table>
</div>
</body>
<?php
return memberpage();
}
function investmentReturn(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

$idea="select Returns, investment_id,businessname from investmentreturns";
$idea_query=mysql_query($idea);
$rows=mysql_num_rows($idea_query);
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
</style>
</head>
<body>
	<div class="reports">
<?php
echo "<table border=1>
<tr><th> RETURNS</th> <th>INVESTMENT ID</th> <th>BUSINESS NAME</th></tr>";
?>
<?php
for($i=0;$i<$rows;$i++){
$idea_array=mysql_fetch_row($idea_query);
$idea_array[0];
$idea_array[1];
$idea_array[2];
$idea_array1[$i]=$idea_array[0];
$idea_array2[$i]=$idea_array[1];
$idea_array3[$i]=$idea_array[2];
?>
<tr>
	<td> <?php echo $idea_array1[$i]; ?></td>
	<td> <?php echo $idea_array2[$i]; ?></td>
	<td> <?php echo $idea_array3[$i]; ?></td>

<?php
}
?>
</tr>
</table>
</div>
</body>
</html>
<?php
return memberpage();
}

function regular(){
$regular="select MemberID,Name From regularmember";
$regular_query=mysql_query($regular);
$rows=mysql_num_rows($regular_query);
?>
<!DOCTYPE html>
<html>
<head>
<style>
.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
</style>
</head>
<body>
	<div class="reports">
<?php
echo "<table border=1>
<tr><th> MEMBER ID</th> <th>FIRST NAME</th></tr>";
?>
<?php
for($i=0;$i<$rows;$i++){
	$regular_array=mysql_fetch_row($regular_query);
	$regular_array[0];
	$regular_array[1];
	$regular_array1=$regular_array[0];
    $regular_array2=$regular_array[1];
    ?>
    
    <td><?php echo $regular_array1;?></td><td><?php echo $regular_array2;?></td>

    <?php
}
?>

</tr>
</table>
</div>
<?php

return memberpage();
}
function benefit(){
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
$benefits="select MemberId, Benefits from memberbenefits";
$benefits_query=mysql_query($benefits);
$rows=mysql_num_rows($benefits_query);
?>
<html>
	
	<head>
		<style type="text/css">
			.reports{
				margin-left:250px;
				position:absolute;
				padding:20px;
				margin-top:10px;
				width:700px;
				
			}
			
		</style>	
	</head>
	<body>
		<div class="reports">
<table border=1>
  <tr><th> MEMBER ID</th> <th>BENEFITS</th></tr>
  <?php
for($i=0;$i<$rows;$i++){

	$benefits_array=mysql_fetch_row($benefits_query);
    $benefits_array[0];
    $benefits_array[1];
    $benefits_array1[$i]=$benefits_array[0];
    $benefits_array2[$i]=$benefits_array[1];
?>


<tr>
<td> <?php echo $benefits_array1[$i];?></td>
<td> <?php echo $benefits_array2[$i];?></td>

<?php


}
?>
</tr>
</table>
</div>
</body>
<?php
return memberpage();
}

function pending() {
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	echo "<h1>FAMILY SACCO</h1>";
	echo "<h3>CONTRIBUTION(S) IN PENDING STATE</h3>";

	$a = "select * from Contributionpending";
	$b = mysql_query($a);

	$c = mysql_num_rows($b);

	for ($d = 0 ; $d < $c ; ++$d) {

		$fetch = mysql_fetch_row($b);

		echo 'Name:'. $fetch[2].'<br/>';
		echo 'Amount:'. $fetch[0].'<br/>';
		echo 'Date:'. $fetch[1].'<br/>';
		echo 'Receipt number:'. $fetch[3].'';
		echo 'MemberID:'. $fetch[4].'<br/>';

	echo<<<_end
	 <form action="try.php?action=pending" method="POST">
	 		<input type="hidden" name="name" value="$fetch[2]">
	 		<input type="hidden" name="amount" value="$fetch[0]">
	 		<input type="hidden" name="date" value="$fetch[1]">
			<input type="hidden" name="receiptno" value="$fetch[3]">
			<input type="hidden" name="Member" value="$fetch[4]">
			<input type="submit" value="APPROVE" name="approve">
			<input type="submit" value="DENY" name="deny">
	 </form>
_end;
}
	$name=$_POST['name'];
	$amount=$_POST['amount'];
	$date=$_POST['date'];
	$receiptno=$_POST['receiptno'];
	$member=$_POST['Member'];
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
		
		if(isset($_POST['deny'])) {
	
	$e="delete from Contributionpending where receiptno='$receiptno'";
	$f=mysql_query($e);

}

		if(isset($_POST['deny'])) {
			echo $name;
			echo $amount;
			echo $date;
			echo $receiptno;
			echo "Denied";

	$g="insert into Contributions_Denied values ('$amount','$date','$name','$receiptno','$member')";
	$h=mysql_query($g);
}
		if (isset($_POST['approve'])) {

	$k="delete from Contributionpending where receiptno='$receiptno'";
	$l=mysql_query($k);
}

		if(isset($_POST['approve'])) {
			echo $name;
			echo $amount;
			echo $date;
			echo $receiptno;
			echo "Approved";

	$i="insert into MemberContributions values ('$name','$amount','$date','$receiptno','$member')";
	$j=mysql_query($i);

	}
	return adminpage();
}

function cut() {
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$filename="/home/fayth/Desktop/Recess/family_sacco.txt";
	$fo=fopen($filename, "r");
	$fsize=filesize($filename);
	$fr=fread($fo, $fsize);

	$a=explode("\n", $fr);

	$c=count($a);
	for ($d=0; $d < $c; $d++) { 
			$b=explode(" ", $a[$d]);
			print_r($b);

		if (strcmp($b[0], "contribution")==0) {
			$e="insert into Contributionpending values ('$b[1]','$b[2]','$b[3]','$b[4]','$b[5]')";
			$f=mysql_query($e);
		}
		
		if (strcmp($b[0], "loan")==0) {
			$date = time();
			$date = date('Y-m-d',$date);
			$k="insert into LoanRequest (LoanID,LoanAmount,LoanDate,MemberID) values (NULL,'$b[2]','$date','$b[3]')";
			$h=mysql_query($k);
		}

		if (strcmp($b[0], "idea")==0) {
			$i="insert into pendingidea values (NULL,'$b[2]','$b[1]','$b[3]')";
			$j=mysql_query($i);
		}	
	
}	
	unlink('/home/fayth/Desktop/Recess/family_sacco.txt');
	
	fclose($fo);
	return adminpage();
}


?>    

