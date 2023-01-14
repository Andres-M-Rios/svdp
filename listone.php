<!DOCTYPE html>
<?php
//Test if vincentian has signed in
if (!isset($_COOKIE['svdp']))
{
	header("Location:index.php");
	exit;
}
//default client is a new client
$selection = "new";
if (isset($_GET["clientid"])) 
	$selection =$_GET["clientid"];

//if client is new, proceed to the report 
if ($selection=="new")
{
	header("Location:visit.php");
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
<title>SSVDP individual record</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="svdp.css">

</head>
<body><div align="center">
<?php
// input date is of the form: mm/dd/yyyy (leading zeroes are optional)
function mydate($x)
{	$month = array( 1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec");
	$t = $x;
	$n = strpos($t,"/");
	$mo = substr($t,0,$n);
	if (intval($mo)<1 || intval($mo)>12) return"";
	$t = substr($t,$n+1);
	$n = strpos($t,"/");
	$da = substr($t,0,$n);
	$ye = substr($t,$n+1);
	return $month[$mo]." $da, ".$ye;
}
// by default, grab the first record (record #0)
	
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
	

echo"<table bgcolor='#31a0ff' cellspacing=0 cellpadding=8 width=850>";
echo"<tr><td class='fieldtitle' >".$vincentian[4]." ".$vincentian[3]." is signed in<br><br>";
echo"<img src='images/svdp.jpg'></td>\n";


echo"<td valign='top' class='links'><a href='index.php'>log out</a><br>";
echo"<a href='list.php'>display list</a><br>";
echo"<a href='visit.php?clientid=".$selection."'>report visit</a></td></tr></table>";


echo"<table bgcolor='#31a0ff' cellspacing=0 cellpadding=10 width=850><tr><td>";
echo"<table border=0 cellspacing=0 cellpadding=0 width=100%><tr>";
echo"<td  class='fieldtitle' align='right'>last visited: ".mydate($field[12])." &nbsp; &nbsp;</td></tr></table>\n";

// name-address-telphone box
echo"<table width='100%' class='borders'><tr><td><table width='100%' cellspacing=4 cellpadding=3 border=0 >\n";

echo"<tr><td width='67%' rowspan = 2 class='name'>".$field[0].", ".$field[1]."</td>";
echo"<td width='33%' class='normal'>".$field[2]."</td></tr><tr><td width='33%' class='normal'>".$field[3]."</td></tr>\n";
if (strlen($field[15])>2) 
	echo"<tr><td colspan=2 class='flag'>".$field[15]."</td></tr>";
echo"</table></td></tr></table><br>\n";

// middle box: contains left and right boxes
echo"<table border=0 cellspacing=0 cellpadding=0 width='100%'><tr><td width='30%' valign='top'>\n";
// left box: contains family statistics
echo"<table width='100%' cellpadding=0 cellspacing=0 border=0 class='borders'><tr><td><table width='100%' cellspacing=10 cellpadding=3 border=0 bgcolor='#88ccff'>\n";
echo"<tr><td colspan=2 class = 'links'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Family&nbsp;Statistics</td></tr>\n";
echo"<tr><td width=80% align='right' class='fieldtitle'><b>number of<br> adults</b></font></td>";
echo"<td width=20% class='normal' bgcolor='ffffff'>".$field[4]."</td></tr>\n";
echo"<tr><td width=80% align='right' class='fieldtitle'><b>number of children<br>of preschool age</b></font></td>";
echo"<td width=20% class='normal' bgcolor='ffffff'>".$field[5]."</td></tr>\n";
echo"<tr><td width=80% align='right' class='fieldtitle'><b>number of children<br>of grade school age</b></font></td>";
echo"<td width=20% class='normal' bgcolor='ffffff'>".$field[6]."</td></tr>\n";
echo"<tr><td width=80% align='right' class='fieldtitle'><b>number of<br>teenagers</b></font></td>";
echo"<td width=20% class='normal' bgcolor='ffffff'>".$field[7]."</td></tr>\n";
echo"</tr></table></td></tr></table></td><td width=5%> &nbsp; </td><td width='65%'>";
// Filemaker Pro (original source file) uses chr(11) for internal returns for textareas
$work=str_replace(chr(11),"<br>",$field[8]);
// right box: contains information from DATA SHEETS
echo"<table width='100%' cellpadding=0 cellspacing=0 border=0 class='borders' ><tr><td><table width='100%' cellspacing=10 cellpadding=3 border=0 bgcolor='#88ccff'>\n";
echo"<tr><td colspan=4 class = 'links'> &nbsp; &nbsp; Information&nbsp;from&nbsp;DATA&nbsp;SHEETS</td></tr>";
echo"<tr><td colspan=4  class='fieldtitle'> <div align='right'> last updated: ".mydate($field[11])."</div></td></tr>\n";
echo"<tr><td colspan=4 width=100% height=100 bgcolor='ffffff' valign='top' class='normal'>".$work."</td></tr>\n";
echo"<tr><td width=50% align='center' colspan=2 class = 'links'>Household Income</td>";
echo"<td width=50% align='center' colspan=2 class = 'links'>Household Expenses</td>";

// income and expenses: complete 4 repeated area, that may be missing by default
$income = $field[9];
$expenses = $field[10];
$temp = 3-substr_count($income,chr(29));
$income .=substr(chr(29).chr(29).chr(29),0,$temp)."<br>";
$income = "$".str_replace(chr(29),"<br>$",$income);
$income = str_replace("$<br>","$---<br>",$income);
$temp = 3-substr_count($expenses,chr(29));
$expenses .=substr(chr(29).chr(29).chr(29),0,$temp)."<br>";
$expenses = "$".str_replace(chr(29),"<br>$",$expenses);
$expenses = str_replace("$<br>","$---<br>",$expenses);
echo"<tr><td width=35% align='right' class = 'fieldtitle'>Employment <br>Social Assistance <br>Child Benefit <br>Spousal Support </td><td width=15% bgcolor='ffffff' align='center' valign='top'class = 'normal'>".$income."</td>";
echo"<td width=35%  align='right'class = 'fieldtitle'>Rent <br>Utilities <br>Groceries <br>Other </td><td width= 15% bgcolor='ffffff' align='center' valign='top'class = 'normal'>".$expenses."</td>";
//echo"<td width=40% bgcolor='ffffff' align='center'></td></tr>\n";	
echo"</table></td></tr></table></td></tr></table>";
// end of middle box

// both "contacts" and "dates" are repeating fields
$contacts = str_replace(chr(29),"<br>",$field[14]);
$dates = $field[13];
$list=explode(chr(29),$dates.chr(29)."end");
$count=0;
$datelist="";
while($list[$count] != "end")
	{
		$datelist.=mydate($list[$count])."<br>";
		$count++;
	}
	
echo"<br><table width='100%' cellpadding=0 cellspacing=0 border=0 class='borders'><tr><td><table width='100%' cellspacing=10 cellpadding=3 border=0 bgcolor='#88ccff'>\n";
echo"<tr><td colspan=2 align='center' class = 'links'> Contacts by Vincentians</td></tr>\n";
echo"<tr><td width=15% bgcolor='ffffff' align='right' valign='top' class = 'normal'>".$datelist."</td>\n";
echo"<td width=85% bgcolor='ffffff' align='left' valign='top'class= 'normal'>".$contacts."</td></tr></table>\n";
echo"</td></tr></table></td></tr></table>\n";
?>
</div></body>
</html>