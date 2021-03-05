<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subir OP Recibida</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
	font-weight: bold;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.Estilo1 {	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
</head>
<?php 
if($REQUEST_METHOD = "POST"){   //if($REQUEST_METHOD<>"POST"){ No funciona en php7
?>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%"><span class="Estilo1">SUBIR ARCHIVO OP RECIBIDA</span></td>
    <td width="7%" rowspan="2" align="right"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td><span class="Estilo4">COMERCIO EXTERIOR</span></td>
  </tr>
</table>
<br />
<br />
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right"><a href="../gestiondeinformes.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<br />
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td><form action="subiroprecibida.php" method="post" enctype="multipart/form-data" name="archivos" target="_blank" id="archivos">
      <input name="archivo1" type="file" size="60" maxlength="60" />
      <input name="Submit" type="submit" value="Subir" />
    </form></td>
  </tr>
</table>
<?php
   } 
    else{ 
    $directorio="D:\\comercioexterior\\oprecibida\\"; 
         copy ($archivo1,$directorio.$archivo1_name); 
    echo  "El archivo: ".$archivo1_name."<br>Fu&eacute; subido al servidor.<br>";  
   } 
?>
<br />
<br />
<br />
<br />
<br />
<br />
</body>
</html>