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

<body text="#003399"><div align="center">
<table width=900 border=0 bgcolor='#31a0ff' cellspacing=0 cellpadding=10>
<?php
echo"<tr><td class=\"fieldtitle\" width=700> &nbsp; &nbsp;". $vincentian[4] .' '. $vincentian[3] ." is signed in<br><br></td>";
echo"<td  rowspan=2 class=\"links\" ><a href=\"index.php\">sign out</a><br><a hrsef=\"list.php\">list clients</a><br><a href=\"changepassword.php\">change pw</a>";
echo"</td></tr>";
echo"<tr><td><img src=\"". $headerpicture ."\"></td></tr>\n";
?>
</table>
<table  width=900 border=0 bgcolor='#31a0ff' cellspacing=0 cellpadding=20>
<tr><td align='center'><hr>
<form name='form1' action='stats.php' id='form1' method='post'>
<h3>Seaching for events between the following two dates of the year: <select name="startY">
                            <option selected value=year>year</option>
                            
<?php
$temp = date("Y");
while(intval($temp)>2006)
{
	echo"<option value=$temp>$temp</option>";
	$temp--;                          
}                            
?>     
                           
                           </select></h3>
<br>
<table>
	<tr><td>Enter the starting date:</td><td>
		<select name="startM">
                            <option selected value=month>month</option>

                            <option value=1>Jan</option>
                            <option value=2>Feb</option>
                            <option value=3>Mar</option>
                            <option value=4>Apr</option>
                            <option value=5>May</option>
                            <option value=6>Jun</option>

                            <option value=7>Jul</option>
                            <option value=8>Aug</option>
                            <option value=9>Sep</option>
                            <option value=10>Oct</option>
                            <option value=11>Nov</option>
                            <option value=12>Dec</option>

                          </select> <select name="startD">
                            <option selected value=day>day</option>
                            <option value=01>1</option>
                            <option value=02>2</option>
                            <option value=03>3</option>
                            <option value=04>4</option>

                            <option value=05>5</option>
                            <option value=06>6</option>
                            <option value=07>7</option>
                            <option value=08>8</option>
                            <option value=09>9</option>
                            <option value=10>10</option>

                            <option value=11>11</option>
                            <option value=12>12</option>
                            <option value=13>13</option>
                            <option value=14>14</option>
                            <option value=15>15</option>
                            <option value=16>16</option>

                            <option value=17>17</option>
                            <option value=18>18</option>
                            <option value=19>19</option>
                            <option value=20>20</option>
                            <option value=21>21</option>
                            <option value=22>22</option>

                            <option value=23>23</option>
                            <option value=24>24</option>
                            <option value=25>25</option>
                            <option value=26>26</option>
                            <option value=27>27</option>
                            <option value=28>28</option>

                            <option value=29>29</option>
                            <option value=30>30</option>
                            <option value=31>31</option>
                          </select>
	</td></tr>
		<tr><td>Enter the ending date:</td><td>
		<select name="endM">
                            <option selected value=month>month</option>
							<option value=1>Jan</option>
                            <option value=2>Feb</option>
                            <option value=3>Mar</option>
                            <option value=4>Apr</option>
                            <option value=5>May</option>
                            <option value=6>Jun</option>

                            <option value=7>Jul</option>
                            <option value=8>Aug</option>
                            <option value=9>Sep</option>
                            <option value=10>Oct</option>
                            <option value=11>Nov</option>
                            <option value=12>Dec</option>
							
                           </select> <select name="endD">
                            <option selected value=day>day</option>
                            <option value=01>1</option>
                            <option value=02>2</option>
                            <option value=03>3</option>
                            <option value=04>4</option>

                            <option value=05>5</option>
                            <option value=06>6</option>
                            <option value=07>7</option>
                            <option value=08>8</option>
                            <option value=09>9</option>
                            <option value=10>10</option>

                            <option value=11>11</option>
                            <option value=12>12</option>
                            <option value=13>13</option>
                            <option value=14>14</option>
                            <option value=15>15</option>
                            <option value=16>16</option>

                            <option value=17>17</option>
                            <option value=18>18</option>
                            <option value=19>19</option>
                            <option value=20>20</option>
                            <option value=21>21</option>
                            <option value=22>22</option>

                            <option value=23>23</option>
                            <option value=24>24</option>
                            <option value=25>25</option>
                            <option value=26>26</option>
                            <option value=27>27</option>
                            <option value=28>28</option>

                            <option value=29>29</option>
                            <option value=30>30</option>
                            <option value=31>31</option>
                          </select>

                      
	</td></tr>
	</table><br>
<input type='image' src='images/go.gif' name='go' value='go'></form>
</td></tr></table></div>
</body>
</html>