<!DOCTYPE html>
<?php

$count=0;
$f=fopen("data/svdp.txt","r");
$line = fgets($f,2000);

while(!feof($f))
{
	if (!isset($_POST['check'.$count]))
		$list[$count]=$line;	
	$line = fgets($f,2000);
	$count++;
}
fclose($f);
$f=fopen("data/svdp.txt","w");
foreach($list as $line)
	//echo $line."<br>";
	fputs($f,$line,2000);
fclose($f);
header("Location:adminlist.php");
exit;
?>