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
	$line = fgets($f);
fclose($f);
$vincentian =explode("\t",$line);//field 0=id; 1=pw; 2=access level; 3=last name; 4=first name; 5=email

// if the member has no administrative privileges, go to the start
	if($vincentian[2]!='a')
{
	header("Location:index.php");
	exit;
}
$headerpicture="images/svdpadmin.jpg";

// with authorization, do the following
$f = fopen("data/svpw.txt","r");
echo "<html><head><title>SSVDP Whitby, Ontario</title>";
echo"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"><link rel=\"stylesheet\" type=\"text/css\" href=\"svdp.css\">";
echo"</head><body><table align='center' bgcolor=\"#ccA0ff\"><tr><td align='left'  class=\"fieldtitle\" >".$vincentian[4]." ".$vincentian[3]." is signed in";
echo"<div align=\"center\"><img src=\"".$headerpicture."\"></div></td></tr><tr><td>";

echo"<form action=\"otherpasswords.php\" method=\"post\" id=\"form\" name=\"form\">";
echo"<table border=1  cellspacing=0 cellpadding=0>";

//list all members' names
$count=0;
for($i=0; !feof($f);$i++)
{
	$line = fgets($f);
	$member = explode("\t",$line);
	/* for ($printarr = 0; $printarr <= 5; $printarr++) {
		echo $member[$printarr];
	} //Testing for $member with PHP error on array, even though seems to work fine  
	*/ 
	if(isset ($member[0])) $foundID = (string) $member[0];	
	if(isset ($member[1])) $foundPW = (string) $member[1];
	if(isset ($member[2])) $code =    (string) $member[2];
	if(isset ($member[3])) $last =    (string) $member[3];
	if(isset ($member[4])) $first =   (string) $member[4];
	if(isset ($member[5])) $email =   (string) $member[5];
	
	if (isset($last))
	{
		echo"<tr><td width=20><input type=\"radio\" name=\"member\" size=10 value=\"".$i."\"></td><td width=200> $first $last </td>";
		echo"<td width=100> $foundID </td><td width=100> ******** </td><td width=230> $email </td><td width=50> $code </td></tr>\n";
		$count++;
	}
}

echo"<tr><td><input type=\"radio\" name=\"member\" size=10 value=\"new".$count."\"></td><td> <b>new member</b> </td></tr>\n";

echo"</table><br><br><div align=center><input type='submit'  value='Select this Member' name='submit'>&nbsp;";
echo"<input type = 'button' value='Return to ADMIN' onClick=\"window.location='adminlist.php'\">";
echo"</div></form><br><br></td></tr></table>\n\n";

?>

</td></tr></table>
</body>
</html>

