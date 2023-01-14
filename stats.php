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
$headerpicture="images/svdp.gif";
?>
<html><head><title>Welcome to SSVDP Whitby, Ontario</title>
<link rel='shortcut icon' href='favicon.ico'>
<link rel="stylesheet" type="text/css" href="svdp.css">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<style>
.main a:link { color:#664400; text-decoration:none; font-style:italic; font-size:20px}
.main a:visited {color:#664400; text-decoration:none; font-style:italic; font-size:20px}
.main a:hover {color:#664400; background-color:#cccccc; font-style:italic;  font-size:20px}
.main a:active {color:#664400; text-decoration:none; font-style:italic; font-size:20px}
.email {font-size: 20px; font-family: "Times New Roman", Times, serif; text-align:left}
</style>
</head>

<body text=#003399><div align="center">
<table width=900 border=0 bgcolor='#31a0ff' cellspacing=0 cellpadding=10>
<?php
echo "<tr><td  class=\"fieldtitle\" width=700> &nbsp; &nbsp;" . $vincentian[4] . " " . $vincentian[3] . " is signed in<br><br></td>";
echo"<td  rowspan=2 class=\"links\" ><a href=\"index.php\">sign out</a><br><a href=\"list.php\">list clients</a><br><a href=\"statistics.php\">statistics</a><br><a href=\"changepassword.php\">change password</a>";
echo"</td></tr>";
echo"<tr><td><img src=\"". $headerpicture ."\"></td></tr>\n";
?>
<tr><td colspan=2 align="center"><hr>

	

<?php
// input date is of the form: mm/dd/yyyy (leading zeroes are optional)
function mydate($x)
{
	// converts a date into a single integer
	// where each date has an integer larger than any previous date
	$t = $x;
	$n = strpos($t,"/");
	$mo = substr($t,0,$n);
	if ($mo<1 || $mo>12) $m0=1;
	$t = substr($t,$n+1);
	$n = strpos($t,"/");
	$da = substr($t,0,$n);
	$ye = substr($t,$n+1);
	return intval($ye)*372+intval($mo)*31+intval($da);
}

function thisdate($d,$m,$y)
{
	$month = array( 1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec");
	return $month[$m]." $d, ".$y;
}

$endD= $_POST['endD'];
$endM= $_POST['endM'];
$startY= $_POST['startY'];
if (intval($endD)<0 || intval($endD)>31 ||intval($endM)<1 || intval($endM) >12)
	{
		$endD=date("j");
		$endM=date("n");
	}
$end=intval($startY)*372+intval($endM)*31+intval($endD);
$startD= $_POST['startD'];
$startM= $_POST['startM'];
if (intval($startD)<0 || intval($startD)>31 || intval($startM)<1 || intval($startM) >12 )
	{
		$startD=date("j");
		$startM=date("n");
		$startY=date("Y")-1;
	}

$start=intval($startY)*372+intval($startM)*31+intval($startD);

$count=0;
$adults=0;
$preschool=0;
$gradeschool=0;
$teen=0;
$famtot=0;
$family[1]=0;
$family[2]=0;
$family[3]=0;
$family[4]=0;
$family[5]=0;
$family[6]=0;
$family[7]=0;

if ($startY==date("Y")) $f=fopen("data/svdp.txt","r");
else if ($startY>2006)
	{
		$temp=$startY % 100;
		/*echo($temp);*/
		$f=fopen("data/svdp$temp.txt","r");
		/*echo($f);*/
	}
else 
	{
		$f=fopen("data/svdp.txt","r");
		$endD=1;
		$endM=1;
		$startD=2;
		$startM=1;
	}

$line = fgets($f,1000);
while(!(feof($f)))
{
	$line = fgets($f,1000);
	//keeps track of each record
	$count++;
	//in each record, calculates the size of the family
	$fam=0;
	$line.="\t";
	//last name ignored
	$n = strpos($line,"\t");
	$line = substr($line,$n+1);
	//first name  ignored
	$n = strpos($line,"\t");
	$line = substr($line,$n+1);
	//address ignored
	$n = strpos($line,"\t");
	$line = substr($line,$n+1);
	//telephone ignored
	$n = strpos($line,"\t");
	$line = substr($line,$n+1);

	$n = strpos($line,"\t");
	$tempadults = substr($line,0,$n);
	$line = substr($line,$n+1);
	$fam+=intval($tempadults);
	$n = strpos($line,"\t");
	$temppreschool = substr($line,0,$n);
	$line = substr($line,$n+1);
	$fam+=intval($temppreschool);
	$n = strpos($line,"\t");
	$tempgradeschool = substr($line,0,$n);
	$line = substr($line,$n+1);
	$fam+= intval($tempgradeschool);
	$n = strpos($line,"\t");
	$tempteen = substr($line,0,$n);
	$line = substr($line,$n+1);
	$fam+=intval($tempteen);
	//Data sheets ignored
	$n = strpos($line,"\t");
	$line = substr($line,$n+1);
	//social assistance ignored
	$n = strpos($line,"\t");
	$line = substr($line,$n+1);
	//rental cost ignored
	$n = strpos($line,"\t");
	$line = substr($line,$n+1);
	//last updated date ignored
	$n = strpos($line,"\t");
	$line = substr($line,$n+1);
	//last visited date ignored
	$n = strpos($line,"\t");
	$latest = substr($line,0,$n);
	$line = substr($line,$n+1);
	
	$n = strpos($line,"\t");
	$dates = substr($line,0,$n);
	$line = substr($line,$n+1);

	//  "dates" is a repeating fields of dates in the form: m/d/yyyy
	$list=explode(chr(29),$dates.chr(29)."end");
	$c=0;
	while(trim($list[$c]) != "end")
	{
		$t=intval(mydate($list[$c]));
		if ($t>=intval($start) && $t<=intval($end))
		{
			$adults+=intval($tempadults);
			$preschool+=intval($temppreschool);
			$gradeschool+=intval($tempgradeschool);
			$teen+=intval($tempteen);
			$famtot++;
			if ($fam<2) $family[1]++;
			else if ($fam>7) $family[7]++;
			else $family[$fam]++;
		}
		$c++;
	}
}
fclose($f);
$people=$adults+$preschool+$gradeschool+$teen;
echo"<div align='center'><font color='#99ffff'<h2>Statistics for the period between ".thisdate($startD,$startM,$startY)." and ".thisdate($endD,$endM,$startY)."</h2></font></div><br>\n";
echo"<br><table border=1 width='80%'><tr><td width='50%' bgcolor='88ccff'>";
echo"<br><table cellspacing=0 cellpadding=5 border=0 >\n";
for($i=1;$i<7;$i++)
	echo"<tr><td>families of $i</td><td> ".$family[$i]."</td></tr>\n";
echo"<tr><td>familes of more than 6</td><td>".$family[7]."</td></tr>";
echo"<tr><td><b>total number of families</b></td><td><b> $famtot </b></td></tr></table></td><td width='50%' bgcolor='88ccff'>\n";
echo"<table cellspacing=0 cellpadding=5 border=0 >\n";
echo"<tr><td>total number of adults:</td><td> $adults </td></tr>";
echo"<tr><td>total number of pre-school children:</td><td> $preschool </td></tr>";
echo"<tr><td>total number of gradeschool children:</td><td> $gradeschool </td></tr>";
echo"<tr><td>total number of teenagers:</td><td> $teen </td></tr>";
echo"<tr><td><b>total number of people</b></td><td><b> $people </b></td></tr></table></td></tr></table>\n";

?>
</td></tr></table></div>
</body>
</html>