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
?>

<html>
<head>
<title>File Backup Routine</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="svdp.css">

</head>

<body >
<script language="JavaScript1.2">
				if (document.cookie.length==0) 
					window.location="index.php";
</script>
<div align=center><table border=0 cellpadding=20 cellspacing=0><tr><td align='left' bgcolor="#ccA0ff" class="fieldtitle">
<?php 
	echo $vincentian[4]." ".$vincentian[3]." is signed in";
?>
<br><br><div align="center"><img src='images/svdpadmin.jpg'></div></td></tr>
<tr><td align='center' bgcolor="#ccA0ff"  >
<table width=70%><tr><td class="normal">
Save this textfile about once a month to your computer and if the online file gets corrupted, you have this backup copy to send to <br>John Ketelaars at <a href="mailto:john@ketelaars.org">john@ketelaars.org</a> or <br> Andy Rios at <a href="mailto:webmaster.sjewhitby.ca">webmaster.sjewhitby.ca</a><br>with a request to replace the corrupted file on the SVDP site.<br><br>
</td></tr></table>
<div align="center">
<form>
<input type = 'button' value='download: svdp.txt' onClick="window.location='data/svdp.txt'"> &nbsp;
<input type = 'button' value='return to ADMIN' onClick="window.location='adminlist.php'"> 
</form>
</div><br><br> 
</td></tr></table>
</div>
</body>
</html>
