
<style type="text/css">
<!--
@import url(file:///D|/estilos/estilo12.css);
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(file:///D|/imagenes/JPEG/edificio_corporativo_1.jpg);
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FF0000;
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
.Estilo2 {color: #FFFFFF;
	font-weight: bold;
	font-size: 14px;
}
.Estilo4 {color: #FFFFFF;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-style: normal;
	font-size: 18px;
	font-weight: bold;
}
-->
</style>
<title>Publicaciones - ENERO</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<body onLoad="MM_preloadImages('file:///D|/imagenes/Botones/boton_volver_2.jpg')"><table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td class="Estilo4">INFORMATIVO BURSATIL  - ENERO </td>
  </tr>
  <tr>
    <td><span class="Estilo2">Santander Global Securities</span></td>
  </tr>
</table>
<br>
<br>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td><?
$sizekb = 0.0 ;
$sizemb = 0.0 ;
$dir=opendir('.php');
while ($file = readdir($dir))
{ 
if($file != "publicaciones.php" AND $file != "aspecto2.css" AND $file != "." AND $file != "..") {
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
<table width="95%"  border="0" align="center">
  <tr>
    <td><div align="right"><a href="file:///D|/archivos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','file:///D|/imagenes/Botones/boton_volver_2.jpg',1)"><img src="file:///D|/imagenes/Botones/boton_volver_1.jpg" name="Image1" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<link rel="stylesheet" type="text/css" href="file:///D|/diariooficial/01/aspecto.css">
