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
$vincentian=explode("\t",$line);//field 0=id; 1=pw; 2=access level; 3=last name; 4=first name; 5=email
?>

<html>
<head>
<title>List of Clients</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="svdp.css">

</head>

<body >
<script language="JavaScript1.2">
				if (document.cookie.length==0) 
					window.location="index.php";
</script>
<div align=center><table border=0 cellpadding=20 cellspacing=0><tr><td bgcolor="#31A0ff">


<?php
if (!isset($sortID)) $sortID=0;

$headerpicture="images/svdp.gif";
$width=900;
$f=fopen("data/svdp.txt","r",true);
$line = fgets($f,2000);
$count=0;
while(!feof($f))
{
	$t=explode("\t",$line);
	
	$lastnames[$count] = $t[0];
	$firstnames[$count] =  $t[1];
	$addresses[$count] =  $t[2];
	$telephones[$count] = $t[3];	
	$adults = $t[4];
	$preschool = $t[5];
	$gradeschool = $t[6];
	$highschool = $t[7];
	$work = $t[8];	
	$income = $t[9];
	$expenses = $t[10];
	$datasheet = $t[11];
	$lastdates[$count] = trim($t[12]);
	$redflagged=$t[13];
	
	if (strlen($redflagged)>1) 
		$red[$count] = true;
	else $red[$count]=false;
	
	$fudgedates[$count]=dateVal($lastdates[$count]);
	$eachrecord[$count]=$count;
	
	$line = fgets($f,2000);
	$count++;
}	
$tot=$count;


function convertDate($dat)
{
	$monthlist="JanFebMarAprMayJunJulAugSepOctNovDec";
	if ($dat=="0/0/0") return "---------";
	if (strlen($dat)<3)  return "---------";
	$p=strpos($dat,"/");
	$m=substr($dat,0,$p);
	$temp=substr($dat,$p+1);
	$p=strpos($temp,"/");
	$day=substr($temp,0,$p);
	$month=substr($monthlist,3*$m-3,3);
	$year=substr($temp,$p+1);
	return $day." ".$month." ".$year;
}//convertDate



function dateVal($dat)
{
	$p=strpos($dat,"/");
	$m=substr($dat,0,$p);
	$temp=substr($dat,$p+1);
	$p=strpos($temp,"/");
	$day=substr($temp,0,$p);
	$year=substr($temp,$p+1);
	return 400*intval($year)+31*intval($m)+intval($day);
}//dateVal


// main program
$i=1;

//print header

echo"<table width=900 border=0 bgcolor='#31a0ff' cellspacing=0 cellpadding=10>";
if (isset($temp)) $id= substr($temp,0,1);
echo "<tr><td  class=\"fieldtitle\" >".$vincentian[4]." ".$vincentian[3]." is signed in<br><font color='aa0000'>Click on a header to sort by that header</font><br><br></td>";
echo"<td  rowspan=2 class=\"links\" ><a href=\"index.php\">sign out</a><br><a href=\"statistics.php\">statistics</a><br><a href=\"changepassword.php\">change pw</a>";

if ($vincentian[2]=="a") 
	echo"<br><a href=\"adminlist.php\">admin</a>";
echo"</td></tr>";
echo"<tr><td><img src=\"".$headerpicture."\"></td></table>\n";

echo"<table border=0 cellpadding=0 cellspacing=0><tr><td width=150 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=150 height=1></td><td width=150 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=150 height=1></td><td width=300 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=300 height=1></td><td width=150 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=150 height=1></td><td width=150 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=150 height=1></td></tr></table>\n";
//print headers
echo"<span class='normal'>";
echo"<table border=0 cellpadding=0 cellspacing=0><tr><td width=150 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=150 height=10></td><td width=150 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=150 height=10></td><td width=300 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=300 height=10></td><td width=150 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=150 height=10></td><td width=150 class=\"fieldtitle\"><img src=\"images/blank.gif\" width=150 height=1></td></tr></table>\n";

echo"<table border=0 cellpadding=0 cellspacing=0><tr><td width=150 class=\"fieldtitle\"><a href=\"list.php?sorts=0\">LAST NAME</a></td><td width=150 class=\"fieldtitle\"><a href=\"list.php?sorts=1\">FIRST NAME</a></td><td width=300 class=\"fieldtitle\"><a href=\"list.php?sorts=2\">ADDRESS</a></td><td width=150 class=\"fieldtitle\"><a href=\"list.php?sorts=3\">TELEPHONE</a></td><td width=150 class=\"fieldtitle\"><a href=\"list.php?sorts=4\">LAST SERVED</a></td></tr>\n";

//print lists


if ($sortID==0)
{
	asort($lastnames);
	foreach ($lastnames as $i => $val) 
	{
		echo"<tr><td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$lastnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$firstnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".substr($addresses[$i],0,45)."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$telephones[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".convertDate($lastdates[$i])."</a></td></tr>\n";
	}
}

if ($sortID==1)
{
	asort($firstnames);
	foreach ($firstnames as $i => $val) 
	{
		echo"<tr><td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$lastnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$firstnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".substr($addresses[$i],0,45)."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$telephones[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".convertDate($lastdates[$i])."</a></td></tr>\n";
	}
}
if ($sortID==2)
{
	asort($addresses);
	foreach ($addresses as $i => $val) 
	{
		echo"<tr><td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$lastnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$firstnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".substr($addresses[$i],0,45)."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$telephones[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".convertDate($lastdates[$i])."</a></td></tr>\n";
	}
}
if ($sortID==3)
{
	asort($telephones);
	foreach ($telephones as $i => $val) 
	{
		echo"<tr><td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$lastnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$firstnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".substr($addresses[$i],0,45)."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$telephones[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".convertDate($lastdates[$i])."</a></td></tr>\n";
	}
}
if ($sortID==4)
{
	asort($fudgedates);
	foreach ($fudgedates as $i => $val) 
	{
		echo"<tr><td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$lastnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$firstnames[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".substr($addresses[$i],0,45)."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".$telephones[$i]."</a></td>\n";
		echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$eachrecord[$i].">".convertDate($lastdates[$i])."</a></td></tr>\n";
	}
}
// last record is the new record option
echo"<tr><td class=\"visit\">&nbsp;<a href='listone.php?clientid=new'><font color=red>new client</font></a></td>\n";
echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$tot.">---------------------</a></td>\n";
echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$tot.">---------------------</a></td>\n";
echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$tot.">---------------------</a></td>\n";
echo"<td class=\"visit\">&nbsp;<a href=listone.php?clientid=".$tot.">---------------------</a></td></tr>\n";
echo "</table></span>";
?>
</td></tr></table></div>
</body>
</html>