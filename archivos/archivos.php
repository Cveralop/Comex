<?php
session_start();
$MM_authorizedUsers = "admin,ingre,consu";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../acceso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<style type="text/css">
<!--
@import url("../estilos/estilo12.css");
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
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../imagenes/JPEG/edificio_corporativo_1.jpg);
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<title>Archivos y Publicaciones</title>
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

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_jumpMenuGo(selName,targ,restore){ //v3.0
  var selObj = MM_findObj(selName); if (selObj) MM_jumpMenu(targ,selObj,restore);
}
//-->
</script>
<body onLoad="MM_preloadImages('../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td class="Estilo4">ARCHIVOS Y PUBLICACIONES</td>
  </tr>
  <tr>
    <td><span class="Estilo2">Santander Global Securities</span></td>
  </tr>
</table>
<form name="form1" method="post" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2"><span class="Estilo5">Publicaciones Diario Oficial A&ntilde;o 2007 - 2008 (Enero-Diciembre)</span></td>
    </tr>
    <tr>
      <td width="26%" height="24"><div align="right">Seleccione el mes:</div></td>
      <td width="74%"><select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
        <option>Seleccione mes (2007)</option>
        <option value="diariooficial/2007/01/publicaciones.php">Enero 2007</option>
        <option value="diariooficial/2007/02/publicaciones.php">Febrero 2007</option>
        <option value="diariooficial/2007/03/publicaciones.php">Marzo 2007</option>
        <option value="diariooficial/2007/04/publicaciones.php">Abril 2007</option>
        <option value="diariooficial/2007/05/publicaciones.php">Mayo 2007</option>
        <option value="diariooficial/2007/06/publicaciones.php">Junio 2007</option>
        <option value="diariooficial/2007/07/publicaciones.php">Julio 2007</option>
        <option value="diariooficial/2007/08/publicaciones.php">Agosto 2007</option>
        <option value="diariooficial/2007/09/publicaciones.php">Septiembre 2007</option>
        <option value="diariooficial/2007/10/publicaciones.php">Octubre 2007</option>
        <option value="diariooficial/2007/11/publicaciones.php">Noviembre 2007</option>
        <option value="diariooficial/2007/12/publicaciones.php">Diciembre 2007</option>
      </select>
      <input name="Button1" type="button" class="boton" onClick="MM_jumpMenuGo('menu1','parent',1)" value="Ir"></td>
    </tr>
    <tr>
      <td height="24">&nbsp;</td>
      <td><select name="menu3" class="etiqueta12" id="menu3" onChange="MM_jumpMenu('parent',this,1)">
        <option>Seleccione mes (2008)</option>
        <option value="diariooficial/2008/01/publicaciones.php">Enero 2008</option>
        <option value="diariooficial/2008/02/publicaciones.php">Febrero 2008</option>
        <option value="diariooficial/2008/03/publicaciones.php">Marzo 2008</option>
        <option value="diariooficial/2008/04/publicaciones.php">Abril 2008</option>
        <option value="diariooficial/2008/05/publicaciones.php">Mayo 2008</option>
        <option value="diariooficial/2008/06/publicaciones.php">Junio 2008</option>
        <option value="diariooficial/2008/07/publicaciones.php">Julio 2008</option>
        <option value="diariooficial/2008/08/publicaciones.php">Agosto 2008</option>
        <option value="diariooficial/2008/09/publicaciones.php">Septiembre 2008</option>
        <option value="diariooficial/2008/10/publicaciones.php">Octubre 2008</option>
        <option value="diariooficial/2008/11/publicaciones.php">Noviembre 2008</option>
        <option value="diariooficial/2008/12/publicaciones.php">Diciembre 2008</option>
                        </select>
        <input name="Button3" type="button" class="boton" id="Button3" onClick="MM_jumpMenuGo('menu1','parent',1)" value="Ir"></td>
    </tr>
  </table>
</form>
<form name="form2" method="post" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2"><span class="Estilo5">Publicaciones Informativo Bursatil A&ntilde;o 2007 - 2008 (Enero-Diciembre)</span></td>
    </tr>
    <tr>
      <td width="26%"><div align="right">Seleccione el mes:</div></td>
      <td width="74%"><select name="menu2" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
        <option>Seleccione mes (2007)</option>
        <option value="bursatil/2007/01/publicaciones.php">Enero 2007</option>
        <option value="bursatil/2007/02/publicaciones.php">Febrero 2007</option>
        <option value="bursatil/2007/03/publicaciones.php">Marzo 2007</option>
        <option value="bursatil/2007/04/publicaciones.php">Abril 2007</option>
        <option value="bursatil/2007/05/publicaciones.php">Mayo 2007</option>
        <option value="bursatil/2007/06/publicaciones.php">Junio 2007</option>
        <option value="bursatil/2007/07/publicaciones.php">Julio 2007</option>
        <option value="bursatil/2007/08/publicaciones.php">Agosto 2007</option>
        <option value="bursatil/2007/09/publicaciones.php">Septiembre 2007</option>
        <option value="bursatil/2007/10/publicaciones.php">Octubre 2007</option>
        <option value="bursatil/2007/11/publicaciones.php">Noviembre 2007</option>
        <option value="bursatil/2007/12/publicaciones.php">Diciembre 2007</option>
      </select>
      <input name="Button2" type="button" class="boton" onClick="MM_jumpMenuGo('menu2','parent',1)" value="Ir"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><select name="menu4" class="etiqueta12" id="menu4" onChange="MM_jumpMenu('parent',this,1)">
        <option>Seleccione mes (2008)</option>
        <option value="bursatil/2008/01/publicaciones.php">Enero 2008</option>
        <option value="bursatil/2008/02/publicaciones.php">Febrero 2008</option>
        <option value="bursatil/2008/03/publicaciones.php">Marzo 2008</option>
        <option value="bursatil/2008/04/publicaciones.php">Abril 2008</option>
        <option value="bursatil/2008/05/publicaciones.php">Mayo 2008</option>
        <option value="bursatil/2008/06/publicaciones.php">Junio 2008</option>
        <option value="bursatil/2008/07/publicaciones.php">Julio 2008</option>
        <option value="bursatil/2008/08/publicaciones.php">Agosto 2008</option>
        <option value="bursatil/2008/09/publicaciones.php">Septiembre 2008</option>
        <option value="bursatil/2008/10/publicaciones.php">Octubre 2008</option>
        <option value="bursatil/2008/11/publicaciones.php">Noviembre 2008</option>
        <option value="bursatil/2008/12/publicaciones.php">Diciembre 2008</option>
                        </select>
        <input name="Button4" type="button" class="boton" id="Button4" onClick="MM_jumpMenuGo('menu2','parent',1)" value="Ir"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td><div align="right"><a href="../principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image1','','../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../imagenes/Botones/boton_volver_1.jpg" name="Image1" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<br>
<br>
