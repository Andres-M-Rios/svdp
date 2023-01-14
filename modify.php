<!DOCTYPE html>
<?php
/**
 * Complete file for Modify Records from Admin perspective in svdp record keeping.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web,  please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   FoodBank
 * @package    SVDP
 * @author     Andres M. Partridge-Rios <andy@amprweb.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: 1.0
 * @link       http://svdp.sjewhitby.ca
 * @see        NetOther,  Net_Sample::Net_Sample()
 * @since      File available since Release 1.2.0
 * @deprecated File deprecated in Release 2.0.0
 */

if (!isset($_COOKIE['svdp'])) {
    header("Location:index.php");
    exit;
}
$svdp=$_COOKIE['svdp'];
$n=strpos($svdp,  "svdp",  0); 
  // "svdp" is the delimiter for the numeric code of the vincentian
$m=substr($svdp,  1,  $n-1); 
  //numeric code for the vincentian
$f=fopen("data/svpw.txt",  "r");
for ($i=0; $i<=$m && !feof($f); $i++)
    $line = fgets($f,  1000);
fclose($f);
$vincentian =explode("\t",  $line); 
  //field 0=id; 1=pw; 2=access level; 3=last name; 4=first name; 5=email

$selection = "-1";
if (isset($_GET["clientid"])) {
    $selection =$_GET["clientid"];
}
if ($selection == -1) 
    $selection=10000;
$headerpicture="images/svdpadmin.jpg";
$width=900;
?>

<html>
<head>
<title>SSVDP individual record</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="svdp.css">
</head>


<body>
<script language="JavaScript1.2">
    if (document.cookie.length==0) 
        window.location="index.php";
</script>

<?php

/*** 
 * This function inputs 
 * 
 * @param x $x = date in the form m/d/y
 * @param y $y distinquishes multiple input dates
 *             if the date entered is valid,  it will become the default date
 * 
 * @return input selection display for date
 */
function reversedate($x, $y)
{
    $month = array(0=>" ",  1=>"Jan",  2=>"Feb",  3=>"Mar",  4=>"Apr",  5=>"May",  6=>"Jun",  7=>"Jul",  8=>"Aug",  9=>"Sep",  10=>"Oct",  11=>"Nov",  12=>"Dec");
    $t = explode("/",  $x);
    
    $mo = $t[0];
    if ($mo<1 || $mo>12) 
       $mo=0;
    $da = $t[1];
    if ($da<1 || $da>31) 
        $da="0";
    $ye = $t[2 ];

    // selection input for month
    if ($mo==0) $choice="selected ";
    else $choice="";    
    
    $out="<select name=\"MMonth".$y."\">\n<option ".$choice."value=month>month</option>\n";
    for ($i=1;$i<13;$i++) {
        if ($mo==$i) 
            $choice="selected ";
        else 
            $choice="";
        $out.="<option ".$choice." value=".$month[$i].">".$month[$i]."</option>\n";
    }
    $out.="</select>\n";
    
    // selection input for day
    if ($da==0) 
        $choice="selected ";
    else 
        $choice="";    
    $out.="<select name=\"MDay".$y."\">\n<option ".$choice."value=day>day</option>\n";
    for ($i=1; $i<=31; $i++) {
        if ($da==$i) 
            $choice="selected ";
        else 
            $choice="";
        $out.="<option ".$choice." value=".$i.">".$i."</option>\n";
    }
    $out.="</select>\n";
    
    // selection input for year
    if ($ye==0) 
        $choice="selected ";
    else 
        $choice="";    
    $out.="</select>\n<select name=\"MYear".$y."\">\n<option ".$choice."value=year>year</option>\n";
    for ($i=2009; $i<2030; $i++) {
        if ($ye==$i) 
            $choice="selected ";
        else 
            $choice="";
        $out.="<option ".$choice." value=".$i.">".$i."</option>\n";
    }
    $out.="</select>\n";
    
    return $out;
}


/***
 * Gets var date and outputs in human readable format
 * 
 * @param string $x date in the form  m/d/y
 * 
 * @return mydate string text format: "mmm d,  yyyy"
 */
function mydate($x) 
{    
    $month = array( 1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr", 5=>"May", 6=>"Jun", 7=>"Jul", 8=>"Aug", 9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec");
    $t = explode("/", $x);
    return $month[$t[0]]." ".$t[1].",  ".$t[2];
}

$count=0;
$f=fopen("data/svdp.txt", "r");
$line = fgets($f, 2000);

while ( !feof($f) && $count < $selection ) {
    $line = fgets($f, 2000);
    $count++;
}
$t=explode("\t", $line);
$last = $t[0];
$first = $t[1];
$address = $t[2];
$telephone = $t[3];
$adults = $t[4];
$preschool = $t[5];
$gradeschool = $t[6];
$highschool = $t[7];
$work = $t[8];
$assistance = $t[9];
$rents = $t[10];
$datasheet = $t[11];
$latest = $t[12];
$dates = $t[13];
$contacts = $t[14];
$flag = $t[15];

echo"<table border=1 bgcolor=\"#ccA0ff\" cellspacing=0 cellpadding=20 width=800><tr><td  class=\"fieldtitle\">".$vincentian[4]." ".$vincentian[3]." is signed in<br><br>\n";
echo"<img src=\"$headerpicture\"><br><div align=\"right\">last visited: ".mydate($latest)." &nbsp; &nbsp; </div>\n";
echo"<form name=\"form\" id=\"form\" method=\"post\" action=\"mod2list.php?clientid=$selection\"><input type=\"hidden\" name=\"latest\" value=\"".$latest."\">";
echo"<table width=\"100%\" cellspacing=10 cellpadding=3 border=0 bgcolor=\"#eeccff\"><tr>\n";
echo"<td width=\"50%\" class=\"fieldtitle\"> &nbsp; &nbsp; Last Name:<br><div align=center><input type=\"text\" size=\"40\" name=\"last\" value=\"".$last."\"></div></td>\n";
echo"<td width=\"50%\"class=\"fieldtitle\"> &nbsp; &nbsp; First Name:<br><div align=center><input type=\"text\" size=\"40\" name=\"first\" value=\"".$first."\"></div></td></tr>\n";
echo"<tr><td colspan=2 class=\"fieldtitle\"> &nbsp; &nbsp; Address:<br><div align=center><input type=\"text\" size=\"80\" name=\"address\" value=\"".$address."\"></div></td></tr>\n";
echo"<tr><td  class=\"fieldtitle\"> &nbsp; &nbsp; Telephone: <br><div align=center><input type=\"text\" size=\"40\" name=\"telephone\" value=\"".$telephone."\"></div></td>";
echo"<td  class=\"fieldtitle\"> &nbsp; &nbsp; redflagged:<br> <div align=center><input type=\"text\" name=\"flag\" value=\"".$flag."\" size=\"40\"></div></td></tr></table>\n";
echo"</td></tr></table>";

echo"<table border=2 bgcolor=\"#ccA0ff\" cellspacing=0 cellpadding=20 width=800><tr><td>";

echo"<table border=0 cellspacing=0 cellpadding=0 width=\"100%\"><tr><td width=\"25%\" valign=\"top\">\n";
echo"<table width=\"100%\" cellspacing=10 cellpadding=3 border=0 bgcolor=\"#eeccff\">\n";
echo"<tr><td colspan=2 class=\"header\">Family&nbsp;Statistics</td></tr>\n";
echo"<tr><td width=80% align=\"right\"class=\"fieldtitle\"><b>number of<br>adults</b></td>";
echo"<td width=20% ><input type=\"text\" name=\"adults\" value=\"".$adults."\" size=\"2\"></td></tr>\n";
echo"<tr><td width=80% align=\"right\"class=\"fieldtitle\">number of children<br>of preschool age</b></td>";
echo"<td width=20% ><input type=\"text\" name=\"preschool\" value=\"".$preschool."\" size=\"2\"></td></tr>\n";
echo"<tr><td width=80% align=\"right\"class=\"fieldtitle\"><b>number of children<br>of grade school age</b></td>";
echo"<td width=20% ><input type=\"text\" name=\"gradeschool\" value=\"".$gradeschool."\" size=\"2\"></td></tr>\n";
echo"<tr><td width=80% align=\"right\"class=\"fieldtitle\"><b>number of<br>teenagers</b></td>";
echo"<td width=20% ><input type=\"text\" name=\"highschool\" value=\"".$highschool."\" size=\"2\"></td></tr>\n";
echo"</tr></table>";

echo"</td><td width=5%> &nbsp; </td><td width=\"70%\">";

echo"<table width=\"100%\" cellspacing=2 cellpadding=3 border=0 bgcolor=\"#eeccff\">\n";
echo"<tr><td colspan=4 ><div align=center><span class=\"header\">Information&nbsp;from&nbsp;DATA&nbsp;SHEETS</span></div><br>";
echo"<div align=right><span class=\"fieldtitle\">Data sheet last updated </span>".reversedate($datasheet, "ds")."</div></td></tr>\n";
echo"<tr><td colspan=4 width=100% height=100 valign=\"top\"><textarea cols=60 rows=10 wrap=\"soft\" name=\"work\">";

// in the textfile,  chr(13) is the end of record,  and chr(11) is the end of line within the textarea
// in HTML chr(11) is temporarily converted to standard end of line character: chr(13)
$work = str_replace(chr(11), chr(13), $work);
// php adds the backslash to single quotes for some reason. They need to be deleted.
$work = str_replace("", "\\", $work);

echo $work."</textarea></td></tr>\n";
echo"<tr><td colspan=2 width=60% class=\"header\">Household Income</td>";
echo"<td width=40% colspan=2 class=\"header\">Household Expenses</td></tr>\n";

// household income ($assist) and houshold Expenses ($rent)
$assist = explode(chr(29), $assistance);
$rent =  explode(chr(29), $rents);

echo"<tr><td width=45% class=\"fieldtitle\"><div align=\"right\">Employment </div></td><td width=15%><input type=\"text\" name=\"assistance0\" value=\"".$assist[0]."\" size=\"6\"></td>";
echo"<td width=25% class=\"fieldtitle\"><div align=\"right\">rent </div></td><td width=15%><input type=\"text\" name=\"rent0\" value=\"".$rent[0]."\" size=\"6\"></td></tr>";

echo"<tr><td width=45% class=\"fieldtitle\"><div align=\"right\">Social Assistance </div> </td><td width=15%><input type=\"text\" name=\"assistance1\" value=\"".$assist[1]."\" size=\"6\"></td>";
echo"<td width=25% class=\"fieldtitle\"><div align=\"right\">Utilities  </div></td><td width=15%><input type=\"text\" name=\"rent1\" value=\"".$rent[1]."\" size=\"6\"></td></tr>";

echo"<tr><td width=45% class=\"fieldtitle\"><div align=\"right\">Child Benefit  </div></td><td width=15%><input type=\"text\" name=\"assistance2\" value=\"".$assist[2]."\" size=\"6\"></td>";
echo"<td width=25% class=\"fieldtitle\"><div align=\"right\">Groceries  </div></td><td width=15%><input type=\"text\" name=\"rent2\" value=\"".$rent[2]."\" size=\"6\"></td></tr>";

echo"<tr><td width=45% class=\"fieldtitle\"><div align=\"right\">Spousal Support  </div></td><td width=15%><input type=\"text\" name=\"assistance3\" value=\"".$assist[3]."\" size=\"6\"></td>";
echo"<td width=25% class=\"fieldtitle\"><div align=\"right\">Other  </div></td><td width=15%><input type=\"text\" name=\"rent3\" value=\"".$rent[3]."\" size=\"6\"></td></tr>";

echo"</table></td></tr></table>";

$contacts = str_replace("", "\\", $contacts);
$contactlist = explode(chr(29), $contacts.chr(29)." ");
$list=explode(chr(29), $dates.chr(29)."end");

echo"<br><br><table width=\"100%\" cellspacing=2 cellpadding=3 border=0 bgcolor=\"#eeccff\">\n";

echo"<tr><td colspan=2 class=\"header\"> Contacts by members of SSVDP</td>";

echo"<td align=\"center\"class=\"fieldtitle\">check<br>to<br>remove</tr>\n";

$count=0;
while ($list[$count] != "end") {
    echo"<tr><td width=27% align=\"right\">".reversedate($list[$count], $count)."</td>\n";
    echo"<td width=68% align=\"left\"><input type=text size=70 name=\"contactlist0".$count."\" value=\"".$contactlist[$count]."\"></td>";
    echo"<td width=5% align=\"center\"><input type=\"checkbox\" name=\"check".$count."\" value=1</td></tr>\n";
    $count++;
}

echo"<tr><td colspan=3 align=\"left\"class=\"fieldtitle\">Please complete for the latest visit,  or ignore:</td></tr>";
echo"<tr><td width=27% align=\"right\">".reversedate("0/0/0", $count)."</td>\n";
echo"<td colspan=2 width=73% align=\"left\"><input type=text size=70 name=\"contactlist0".$count."\" value=\"\"></td></tr>\n";
echo"</table><br><input type=\"hidden\" name=\"history\" value=\"".$count."\">";
echo"<div align=center><input type=\"image\" src=\"images/update.gif\" border=0><a href=\"adminlist.php\"><img src=\"images/nosend.gif\" border=0></a></div></form>";

echo"</td></tr></table>\n";

?>

</body>

</html>

