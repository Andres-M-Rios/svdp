<?php

if (!isset($_POST['id']) || strlen($_POST['id'])<2)
{
	header("Location:index.php");
	exit;
}
else 

	$id = $_POST['id'];

if (!isset($_POST['pw'])|| strlen($_POST['pw'])<2)
{
	header("Location:index.php");
	exit;
}
else 

	$pw = $_POST['pw'];

$f = fopen("data/svpw.txt","r");

$found = false;

$count =0;

while(!feof($f))

{

	$line = fgets($f,200);

	$n = strpos($line,"\t");

	$foundID = substr($line,0,$n);

	$line = substr($line,$n+1);

	$n = strpos($line,"\t");

	$foundPW = substr($line,0,$n);

	$line = substr($line,$n+1);

	$n = strpos($line,"\t");

	$code = substr($line,0,$n);

	if(strtoupper($foundID)==strtoupper($id) && $foundPW==$pw)

	{

		$found=true;

		$svdp=$code.$count."svdp";
	
	}

	$count++;

}

fclose($f);



if($found)

{

	setcookie("svdp",$svdp);

	header("Location:list.php");

}

else

	header("Location:index.php");



?>