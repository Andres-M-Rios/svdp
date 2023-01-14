<!DOCTYPE html>
<?php

$m=$_POST['m'];

$pw = $_POST['pw'];

$id = $_POST['id'];

$code = $_POST['code'];

$last = $_POST['last'];

$first = $_POST['first'];

$email = $_POST['email'];



if (!isset($_COOKIE['svdp']))

	header("Location:index.php");

$count=0;

$f = fopen("data/svpw.txt","r");

for($i=0;!feof($f);$i++)
{

	$line[$count] = fgets($f);

	$count++;

}

fclose($f);

$line[$m]=$id."\t".$pw."\t".$code."\t".$last."\t".$first."\t".$email."\n";

if($m==$count) 

	$count++;

if ($code=="c")

{

	$count--;

	$line[$m]=$line[$count];

}

$f=fopen("data/svpw.txt","w");

for ($i=0;$i<$count;$i++)

	fputs($f,$line[$i]);

fclose($f);

$message="Your information has been successfully updated<br>";

echo "<html><head><title>SSVDP Whitby, Ontario</title>";

echo"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"><link rel=\"stylesheet\" type=\"text/css\" href=\"svdp.css\">";

echo"</head><body><div align=center>";

echo"<table border=2 bgcolor='#ccA0ff' cellspacing=0 cellpadding=0><tr><td align='center'>\n";

echo"<img src='images/svdpadmin.jpg'><br><br>".$message."<br>";

echo"<input type = 'button' value='Return to ADMIN' onClick=\"window.location='adminlist.php'\">";


echo"<br><br></td></tr></table><br><br></td></tr></table></div></body></html>\n";

?>

