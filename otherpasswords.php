<!DOCTYPE html>
<?php

if (!isset($_COOKIE['svdp']))
{
	header("Location:index.php");
	exit;
}

$temp=$_COOKIE['svdp'];
if(substr($temp,0,1)!='a')
{
	header("Location:index.php");
	exit;
}

$m = $_POST['member'];

// extract the number of the password record of this member
if (substr($m,0,1)=="n")
{
	$foundID = "New Member";
	$foundPW = "";
	$code = "b";
	$last = "";
	$first = "";
	$email = "";
	$m = substr($m,3);
}
else
{
	$f = fopen("data/svpw.txt","r");
	for($i=0;$i<=$m && !feof($f);$i++)
		$line = fgets($f,200);
	fclose($f);

	// $line is now the record of this member
	$member = explode("\t",$line);
	$foundID = $member[0];
	$foundPW = $member[1];
	$code =    $member[2];
	$last =    $member[3];
	$first =   $member[4];
	$email =   $member[5];
}

echo "<html><head><title>SSVDP Whitby, Ontario</title>";
echo"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"><link rel=\"stylesheet\" type=\"text/css\" href=\"svdp.css\">";
echo"</head><body><div align=center>";
echo"<table border=2 bgcolor='#ccA0ff' cellspacing=0 cellpadding=0><tr><td align='center'>\n";

echo"<img src='images/svdpadmin.jpg'><br><font size=3>User ID: <b>".$foundID."</b></font><br>\n";
echo"<hr><font size=2>Make Changes below: Authorization: &nbsp; &nbsp; &nbsp; &nbsp; a = administrator &nbsp; &nbsp; &nbsp; &nbsp; b = vincentian &nbsp; &nbsp; &nbsp; &nbsp; c = remove vincentian </font><hr><br>";

echo"<form method=\"post\" action=\"updateotherpw.php\" id=\"form\" name=\"form\">";
echo"<input type='hidden' name='m' value='".$m."'><table border=0 cellspacing=0 cellpadding=5>\n";
echo"<tr><td align='right'><font size=3> First Name: </font></td><td><input type='text' name='first' value='".$first."'></td>\n";
echo"<td align='right'><font size=3>User ID: </font></td><td><input type='text' name='id' value=\"".$foundID."\"></td></tr>\n";
echo"<tr><td align='right'><font size=3>Last Name: </font></td><td ><input type='text' name='last' value= '".$last."' ></td>\n";
echo"<td align='right'><font size=3> Password: </font></td><td><input type='text' name='pw' value=\"".$foundPW."\"></td></tr>\n";
echo"<tr><td align='right'><font size=3>Email Address: </font></td><td ><input type='text' name='email' value= '".$email."' ></td>\n";
echo"<td align='right'><font size=3>Authorization: </font></td><td><input type='text' name='code' value=\"".$code."\"></td></tr>\n";
echo"</table><br><br><input type='submit'  value='Make this Change' name='submit'>&nbsp;";
echo"<input type = 'button' value='Return to ADMIN' onClick=\"window.location='adminlist.php'\">&nbsp;";
echo"<input type = 'button' value='Back to VINCENTIANS' onClick=\"window.location='more.php'\">";
echo"</form><br><br></td></tr></table></div>\n\n";



?>





</body>

</html>

