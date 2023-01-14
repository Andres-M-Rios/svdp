<!DOCTYPE html>
<?php
/**
 * File for Re-building the DATA Files,  
 * with hard coded min and max year stuff in here.
 * Look here to fix date bugs.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web,   please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   FoodBank
 * @package    SVDP
 * @author     Andres M. Partridge-Rios <andy@amprweb.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: 1.0
 * @link       http://svdp.sjewhitby.ca
 * @see        NetOther,   Net_Sample::Net_Sample()
 * @since      File available since Release 1.2.0
 * @deprecated File deprecated in Release 2.0.0
 */
/***
 * Change the date to the form acceptable in 
 *   Filemaker Pro: mm/dd/yyyy (leading zeroes optional)
 * 
 * @param string $m month string needs to be converted to Month # in this usage.
 * @param int    $d Day in that Month 
 * @param int    $y The Year,  currently hard limited to 2029,  where I expamded 
 *                  input to on the other form
 * 
 * @return string mm/dd/yyyy for the dates in the saved data.
 * */ 
function mydate($m, $d, $y)
{
    $month = array( 1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr", 5=>"May", 6=>"Jun", 7=>"Jul", 8=>"Aug", 9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec");
    if ($d<1 ||$d>31) return " ";
    if ($y < 2000 || $y > 2029) return " ";
    for ($i=1;$i<13;$i++) {
        if($m==$month[$i]) 
            $m=$i;
    }
    if ($m<1 || $m>12) return " ";
    return $m."/".$d."/".$y;
}
//********************* main program ***********************************

if (!isset($_COOKIE["svdp"])) {
    header("Location:index.php");
    exit;
}
$svdp=$_COOKIE["svdp"];

// if selection is not set,  assume a new record
if (!isset($_GET["clientid"]))
    $selection ="new";
else 
    $selection = $_GET["clientid"];
    
// if the source is "modify.php" or "addnew.php" the following are always defined (to at least blank)
// fields in our text file are tab-separated.
$line = $_POST["last"]."\t";
$line .= $_POST["first"]."\t";
$line .= $_POST["address"]."\t";
$line .= $_POST["telephone"]."\t";
$line .= $_POST["adults"]."\t";
$line .= $_POST["preschool"]."\t";
$line .= $_POST["gradeschool"]."\t";
$line .= $_POST["highschool"]."\t";
$temp = $_POST["work"];
// convert the return character to Filemaker Pro's internal return for textareas: chr(11)
$work = str_replace(chr(13).chr(10), chr(11), $temp);
$line .= $work."\t";
$line .= $_POST["assistance0"].chr(29).$_POST["assistance1"].chr(29).$_POST["assistance2"].chr(29).$_POST["assistance3"]."\t";
$line .= $_POST["rent0"].chr(29).$_POST["rent1"].chr(29).$_POST["rent2"].chr(29).$_POST["rent3"]."\t";
// the date when the data sheet was last updated
$a = $_POST["MMonthds"];
$b = $_POST["MDayds"];
$c = $_POST["MYeards"];
$line .= mydate($a, $b, $c)."\t";
// the two repeating fields,  having "history" repeats (history = number of contacts)
$dates="";
$contacts="";
$history = $_POST["history"];
// only count the repeating sections without a checkmark
for ($i=0; $i<$history; $i++) {
    if (!isset($_POST["check".$i])) {
        $a = $_POST["MMonth".$i];
        $b = $_POST["MDay".$i];
        $c = $_POST["MYear".$i];
        $d = $_POST["contactlist0".$i];
        $dates.=chr(29).mydate($a, $b, $c);
        $contacts.=chr(29).$d;
    }
}
$latest = $_POST["latest"];
// this is the latest repeating section, which may be added if valid, 
// or ignored if not valid
$a = $_POST["MMonth".$history];
$b = $_POST["MDay".$history];
$c = $_POST["MYear".$history];
$d = $_POST["contactlist0".$history];
$temp = mydate($a, $b, $c);
if ($temp > " ") {
    $dates.= chr(29).$temp;
    $contacts.= chr(29).$d;
}
// update the lastest visit date from the last repeating section
$temp=strrpos($dates, chr(29));
$latest = substr($dates, $temp+1);
$line .= $latest."\t";
//the chr(29) is only BETWEEN repeating fields, 
//NOT before, so remove the first character.
$dates = substr($dates, 1);
$contacts = substr($contacts, 1);
$line .= $dates."\t";
$line .= $contacts."\t";
//all records must contain a return at the end
$line .= $_POST["flag "]."\n";
$line=str_replace("\"", "'", $line);
// load all old records into list[]
// update the new record or else,  if it is a new one,  add it to the end

if ($selection=="-1") {
    $f=fopen("data/svdp.txt", "a");
        fputs($f, $line, 2000);
} else {
    $count=0;
    $f=fopen("data/svdp.txt", "r");
    $list[0] = fgets($f, 2000);
    while (!feof($f)) {
        $count++;
        $list[$count] = fgets($f, 2000);
    }
    fclose($f);
    $list[$selection+0]=str_replace("\\", "", $line);
    $f=fopen("data/svdp.txt", "w");
    foreach ($list as $line)
        fputs($f, $line, 2000);
    fclose($f);
}
// go back to the listing
header("Location:modify.php?clientid=$selection");

?>