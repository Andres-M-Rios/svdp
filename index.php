<!DOCTYPE html>
<?php
if ($_COOKIE["svdp"] != " ")
  setcookie("svdp","",time()-60);
?>
<html><head><title>Welcome to SSVDP Whitby, Ontario</title>
<link rel='shortcut icon' href='favicon.ico'>
<link rel="stylesheet" type="text/css" href="svdp.css">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">

</head>
<body>
<div align=center>
<table width=900 border=0 bgcolor='#31a0ff' cellspacing=0 cellpadding=0><tr><td align='center'><br><img src='images/svdp.gif'></td>
<td class="fieldtitle" valign=bottom><form method="post" action="verify.php" id="form" name="form">
User ID: <br><input type='text' name='id' value='' size=15><br>
Password:<br><input type='password' name='pw' value='' size=15>
<input type='submit'  name='submit' value='go'></form></td></tr>
<script type='text/Javascript'>
	document.form.id.focus()
</script>
</table>
<table width=900 border=0 bgcolor='#31a0ff' cellspacing=20 cellpadding=0>
<tr><td><table cellspacing=0 cellpadding=10 border=0><tr>
            <td width=450 class="address">The St. Vincent De Paul Society is an international 
              association of Catholic laymen engaging systematically in personal 
              service of the poor. The society was founded in May 1833 by eight 
              students in Parish under the leadership of Frederick Ozanam. P&egrave;re 
              Bailly, editor of the &#8220;Tribune Catholique&#8221; was its first 
              president. <br>
              <br>
              The society was established in Canada in 1846 at Notre Dame in Montreal 
              through the inspiration of Bishop Bourget. One of the members of 
              that conference, George Muir, came to Toronto, and together with 
              several members of St. Michael&#8217;s Cathedral formed a conference 
              of St. Vincent De Paul there, on November 11, 1850. <br>
              <br>
        In Whitby, the first conference took place at St. John the Evangelist 
        Church in the spring of 1961 by Eugene Dopp, who also became its first 
        President. Father Leo Austin became its Spiritual director. </td>
            <td width=450 class="address">At that time, weekly visits were made to hospitalized 
              parishioners. Scripture readings and the rosary were said at the 
              jail with those inmates who wanted to participate every Sunday. 
              Rides were provided for senior citizens at Fairview Lodge to attend 
              Mass. Assistance was given to the wayfarer stranded on the road 
              in the form of lodgings, meals, etc. Most of these services are 
              now done by other parish ministries. <br>
              <br>
              At the present time, Through the generosity of our parishioners and the schools in our parish, assistance in the form of groceries and clothing, 
              -- and in some cases, rent, utilites, dental and medical assistance-- 
              is given to those in need. <br>
              <br>
              Thanks to the St. John the Evangelist parishioners,
              more than 150 needy families within  our parish boundaries receive generous 
              assistance at Christmas. <br>
 
			  <div align=center class="normal"><table><tr>
                    <td width="88"><img src="images/serviens_spe.jpg" width="77" height="76"></td>
                  <td width="225"><a href="http://www.svdptoronto.org/" target="_blank">Toronto Central Council</a><br>
                      <a href="http://www.ssvp.on.ca/" target="_blank">Ontario Regional Council</a><br>
                    <a href="http://www.ssvp.ca/" target="_blank">National Council of Canada</a><br>
                    <a href="http://www.ssvpglobal.org" target="_blank">International Confederation</a></td>
                </tr></table></div>
			  </td>
          </tr></table>
 </td></tr></table>
</div></body>
</html>
