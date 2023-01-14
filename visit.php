<!DOCTYPE html>
<?php
if (!isset($_COOKIE['svdp']))
{
	header("Location:index.php");
	exit;
}
//default client is a new client
$selection = "new";
//client id using GET mode
if (isset($_GET["clientid"])) 
{
	$selection =$_GET["clientid"];
	$count=0;
	$f=fopen("data/svdp.txt","r");
	$line = fgets($f,2000);
	while(!feof($f) && $count<$selection)
		{
			$line = fgets($f,2000);
			$count++;
		}
	$line.="\t";
	$field = explode("\t",$line);
	$last=$field[0];
	$first=$field[1];
	$address=$field[2];
	$telephone=$field[3];
}
else
{
	$last="";
	$first="";
	$address="";
	$telephone="";
}	


// identity of the vincentian
$svdp=$_COOKIE['svdp'];
$vincentian = array ();
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
<title>SSVDP Report visit</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="svdp.css">
</head>
<body>
<div align="center">
<?php



echo"<form method='post' name='form1' id='form1' action='send.php'>";		

//---------------------------------------------------------------------------------------
echo"<table bgcolor='#31a0ff' cellspacing=0 cellpadding=8 width=700>";
echo"<tr><td colspan=2 class='fieldtitle' >".$vincentian[4]." ".$vincentian[3]." is signed in<br><br>";
echo"<img src='images/svdp.jpg'></td></tr><tr>\n";
echo"<td width='50%' class='fieldtitle'> &nbsp; &nbsp; Last Name:<br><div align=center><input type='text' size='40' name='last' value='".$last."'></div></td>\n";
echo"<td width='50%'class='fieldtitle'> &nbsp; &nbsp; First Name:<br><div align=center><input type='text' size='40' name='first' value='".$first."'></div></td></tr>\n";
echo"<tr><td colspan=2 class='fieldtitle'> &nbsp; &nbsp; Address: (update if necessary)<br><div align=center><input type='text' size='80' name='address' value='".$address."'></div></td></tr>\n";

echo"<tr><td  class='fieldtitle'> &nbsp; &nbsp; Telephone: (update if necessary)<br><div align=center><input type='text' size='40' name='telephone' value='".$telephone."'></div></td><td>&nbsp;</td></tr>\n";

echo"<tr><td colspan=2 class='fieldtitle'><div align=center> &nbsp; &nbsp; Report&nbsp;on&nbsp;this&nbsp;visit<br><textarea name='info' cols='65' rows='5' >&nbsp;</textarea></div></td></tr>\n";
echo"<tr><td width='50%' valign='top'class='fieldtitle'> &nbsp; &nbsp; Vincentian name(s)<br><div align=center><input type='text' size='30' name='vincentian' value=\"".$vincentian[4]." ".$vincentian[3]."\"></div><br><br></td>\n";
echo"<td width='50%' valign='top' class='fieldtitle'> &nbsp; &nbsp; Date of this visit:<br><div align=center><input type='text' size='30' name='visitdate' value=''></div><br><br></td></tr>\n";

echo"</table><br><input type='hidden' name='vemail' value='".trim($vincentian[5])."'><input type='hidden' name='send' value='0'>\n";
echo"<input type='image' src='images/send.gif' onClick='send.value=1'>&nbsp;\n";
echo"<input type='image' src='images/nosend.gif' onClick='send.value=0'><br><br>\n";


//------------------------------------------------------------------------------------------
echo"</td></tr></table></form>\n";

?>


</div>
</body>
</html>