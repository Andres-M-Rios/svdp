<!DOCTYPE html>
<?php
//subroutines

// this routine fills the array $vincentian[]
// it finds the vincentian numberic code from the cookie
// and uses it to locate the details off the database containing all vincentians: svpw.txt
// call the functionas follows (for example):
//     $vincentian = vincentian();
//     echo $vincentian[3];
//where...
// $vincentian[0] is the userID
// $vincentian[1] is password
// $vincentian[2] is access level: a= admin, b=regular, c=retired
// $vincentian[3] is Last name
// $vincentian[4] is First name
// $vincentian[5] is email address
function vincentian()
{
	$svdp=$_COOKIE['svdp'];
	$n=strpos($svdp,"svdp",0);// "svdp" is the delimiter for the numeric code of the vincentian
	$m=substr($svdp,1,$n-1);//numeric code for the vincentian
	$f=fopen("data/svpw.txt","r");
	for($i=0;$i<=$m && !feof($f);$i++)
		$line = fgets($f,1000);
	fclose($f);
	return  explode("\t",$line);
}

//loads one client, identified by number
function getOne($m)
{
	$field =array("","","","","","","","","","","","","","","","");
	if ($m>0)	
	{
		$count=0;
		$f=fopen("data/svdp.txt","r");
		$line = fgets($f,2000);
		while(!feof($f) && $count<$m)
			{
				$line = fgets($f,2000);
				$count++;
			}
		fclose($f);
		$line.="\t";
		$field = explode("\t",$line);
	}
	return $field;
}
$list = getOne(16);
echo $list[13];


?>