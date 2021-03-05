<html> 
<head> 
<title>Subir Archivos - D Oficial</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
@import url("../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../imagenes/JPEG/edificio_corporativo_1.jpg);
}
.Estilo1 {
	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
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
</head> 
<?php 
if($REQUEST_METHOD<>"POST"){ 
?><body onLoad="MM_preloadImages('../imagenes/Botones/boton_volver_2.jpg')"> 
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td><div align="center"><span class="Estilo1">SUBIR ARCHIVO DE CONCILIACIONES</span></div></td>
  </tr>
</table>
<br>
<br>
<table width="95%"  border="1" align="center" bordercolor="#666666">
  <tr>
    <td><form action="subirconciliaciones.php" method="post" enctype="multipart/form-data" name="archivos" target="_blank">
      <input name="archivo1" type="file" size="60" maxlength="60">
      <input name="Submit" type="submit" value="Subir">
    </form>     </td>
  </tr>
</table>
<?php
   } 
    else{ 
    $directorio="D:\\appserv\\www\\comex\\archivos\\conciliaciones\\"; 
         copy ($archivo1,$directorio.$archivo1_name); 
    echo  "El archivo: ".$archivo1_name."<br>Fu&eacute; subido al servidor.<br>";  
   } 
?>
<br>



<tr> 
  <table width="95%"  border="0" align="center">
  <tr>
    <td><div align="right"><a href="../principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image1" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body> 
</html> 
