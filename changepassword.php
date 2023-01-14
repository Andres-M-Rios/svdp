<!DOCTYPE html>
<?php

if (!isset($_COOKIE['svdp']))
{
	header("Location:index.php");
	exit;
}
$svdp=$_COOKIE['svdp'];
$n=strpos($svdp,"svdp",0);// "svdp" is the delimiter for the numeric code of the vincentian
$m=substr($svdp,1,$n-1);//numeric code for the vincentian
$f=fopen("data/svpw.txt","r");
for($i=0;$i<=$m && !feof($f);$i++)
	$line = fgets($f,1000);
fclose($f);
$vincentian =explode("\t",$line);//field 0=id; 1=pw; 2=access level; 3=last name; 4=first name; 5=email

echo "<html><head><title>SSVDP Whitby, Ontario</title>";

echo"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">";

echo"</head><body>";

echo"<table border=2 bgcolor='#31a0ff' cellspacing=0 cellpadding=0><tr><td align='center'>\n";

echo"<img src='images/svdp.jpg'><br><font size=3>User ID: <b>".$vincentian[0]."</b></font><br>\n";

echo"<font size=2>You must enter your current valid password, for any changes to take place</font><br><br>";

echo"<form method=\"post\" action=\"updatepasswords.php\" id=\"form\" name=\"form\">";

echo"<input type='hidden' name='m' value='".$m."'><table border=0 cellspacing=0 cellpadding=5>\n";

echo"<tr><td align='right'><font size=3> First Name: </font></td><td><input type='text' name='first' value='".$vincentian[4]."'></td>\n";

echo"<td align='right'><font size=3> current password: </font></td><td><input type='password' name='pw' value='**********'></td></tr>\n";

echo"<tr><td align='right'><font size=3>Last Name: </font></td><td ><input type='text' name='last' value= '".$vincentian[3]."' ></td>\n";

echo"<td align='right'><font size=3>new password: </font></td><td><input type='password' name='npw1' value='**********'></td></tr>\n";

echo"<tr><td align='right'><font size=3>Email Address: </font></td><td ><input type='text' name='email' value= '".$vincentian[5]."' ></td>\n";

echo"<td align='right'><font size=3>new password: </font></td><td><input type='password' name='npw2' value='**********'></td></tr>\n";

echo"</table><br><br><input type='image' src='images/modify.gif' name='submit'>";

echo"<a href='list.php'><img src='images/nosend.gif' border=0></a>";

echo"</form><br><br></td></tr></table>\n\n";



?>





</body>

</html>

