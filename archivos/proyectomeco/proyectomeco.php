<html> 
<head> 
<title>Proyecto Nuevo Meco</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
@import url("../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
}
.Estilo1 {
	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<link rel="shortcut icon" href="../../../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../comex/imagenes/barraweb/animated_favicon1.gif">
</head> 
<?php 
if($REQUEST_METHOD<>"POST"){ 
?><body> 
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%"><div align="left"><span class="Estilo1">PROYECTO NUEVO MECO</span></div></td>
    <td width="7%" rowspan="2"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43"></td>
  </tr>
  <tr>
    <td><span class="Estilo4">COMERCIO EXTERIOR</span></td>
  </tr>
</table>
<br>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td><form name="archivos" method="post" action="proyectomeco.php" enctype="multipart/form-data" target="_blank">
      <input name="archivo1" type="file" size="60" maxlength="60">
      <input name="Submit" type="submit" value="Subir">
</form></td>
  </tr>
</table>
<?php
   } 
    else{ 
    $directorio="D:\\appserv\\www\\comex\\archivos\\proyectomeco\\"; 
         copy ($archivo1,$directorio.$archivo1_name); 
    echo  "El archivo: ".$archivo1_name."<br>Fu&eacute; subido al servidor.<br>";  
   } 
?>
<br>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td><?
$sizekb = 0.0 ;
$sizemb = 0.0 ;
$dir=opendir('.');
while ($file = readdir($dir))
{ 
if($file != "proyectomeco.php" AND $file != "erroracceso.php" AND $file != "." AND $file != "..") {
  {
   if((filesize($file) < 1024) AND (filesize($file) > 1)){ $sizekb = filesize($file);
   echo"<a href=\"$file\">&nbsp;$file</a> @ $sizekb bytes<br>"; }
   if((filesize($file) > 1024) AND (filesize($file) < 1024000)){ $sizekb = round(filesize($file)/1024,2);
   echo"<a href=\"$file\">&nbsp;$file</a> @ $sizekb Kb<br>"; }
   if(filesize($file) > 1024000){ $sizekb = round(filesize($file)/1024000,2);
   echo"<a href=\"$file\">&nbsp;$file</a> @ $sizekb Mb<br>"; }
  }
}
}
closedir($dir) ;
?></td>
  </tr>
</table>
<br>
<tr>

</body> 
</html> 