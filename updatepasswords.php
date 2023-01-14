<!DOCTYPE html>
<?php

$test=true;

$m=$_POST['m'];

$pw = $_POST['pw'];

$npw1 = $_POST['npw1'];

$npw2 = $_POST['npw2'];

$last = $_POST['last'];

$first = $_POST['first'];

$email = $_POST['email'];





if (!isset($_COOKIE['svdp']) || $pw=="**********")

{

	$test=false;

}



else

{

	if ($npw1 != $npw2)

	{

		$test=false;

	}

	$count=0;

	$f = fopen("data/svpw.txt","r");

	for($i=0;!feof($f);$i++)

	{

		$line[$count] = fgets($f,200);

		$count++;

	}

	fclose($f);

	$temp=$line[$m];

	$n = strpos($temp,"\t");

	$id = substr($temp,0,$n);

	$temp = substr($temp,$n+1);

	$n = strpos($temp,"\t");

	$oldpw = substr($temp,0,$n);

	$temp = substr($temp,$n+1);

	$n = strpos($temp,"\t");

	$code = substr($temp,0,$n);

	echo $oldpw." === ".$pw;

	if ($oldpw != $pw)

	{

		$test=false;

	}

}

if (!$test)

{

	$message="Your information has not changed<br>";

}

else

{

	if ($npw1 == "**********")

		$npw1 = $pw;

	$line[$m]=$id."\t".$npw1."\t".$code."\t".$last."\t".$first."\t".$email."\n";



	$f=fopen("data/svpw.txt","w");

	for ($i=0;$i<$count;$i++)

		fputs($f,$line[$i],200);

	fclose($f);

	$message="Your information has been successfully updated<br>";

}

echo "<html><head><title>SSVDP Whitby, Ontario</title>";

echo"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">";

echo"</head><body>";

echo"<table border=2 bgcolor='#31a0ff' cellspacing=0 cellpadding=0><tr><td align='center'>\n";

echo"<img src='images/svdp.jpg'><br><br>".$message;

echo"<a href='list.php'><img src='images/display.gif' border=0></a><br>";

echo"</td></tr></table><br><br></td></tr></table></body></html>\n";

?>

