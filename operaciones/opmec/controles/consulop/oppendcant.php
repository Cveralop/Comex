<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE";
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
$MM_restrictGoTo = "../../erroracceso.php";
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
<?php
$colname_cantidad = "zzz";
if (isset($_GET['fecha_ingreso'])) {
  $colname_cantidad = (get_magic_quotes_gpc()) ? $_GET['fecha_ingreso'] : addslashes($_GET['fecha_ingreso']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cantidad = sprintf("SELECT evento,count(id)as total,sum(sub_estado = 'Pendiente.')as pendienteop,sum(estado = 'Pendiente.')as pendientesup,sum(estado = 'Cursada.')as cursado,sum(estado = 'Reparada.')as reparadas FROM opmec WHERE fecha_ingreso LIKE '%%%s%%' GROUP BY evento", $colname_cantidad);
$cantidad = mysql_query($query_cantidad, $comercioexterior) or die(mysqli_error());
$row_cantidad = mysqli_fetch_assoc($cantidad);
$totalRows_cantidad = mysqli_num_rows($cantidad);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control Operaciones Pendientes Cantidad</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
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
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<style type="text/css">
<!--
.Estilo9 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONTROL OPERACIONES PENDIENTES CANTIDAD</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">MERCADO DE CORREDORES</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Cantidad de Operaciones Pendientes de Curse</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Fecha Ingreso:</div></td>
      <td width="79%" align="left"><input name="fecha_ingreso" type="text" class="etiqueta12" id="fecha_ingreso" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
        <span class="rojopequeno">(dd-mm-aaaa) &oacute; (mm-aaaa) &oacute; (aaaa)</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
          <input name="Submit" type="submit" class="etiqueta12" value="Enviar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_cantidad > 0) { // Show if recordset not empty ?>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td align="center"><span class="Estilo7"><span class="titulocolumnas">Evento</span></span></td>
    <td align="center" class="titulocolumnas">Total Operaciones
      </div>
    </td>
    <td align="center" class="titulocolumnas">Operaciones Pendientes Operador 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Operaciones Pendientes Supervisor
      </div>
    </td>
    <td align="center" class="titulocolumnas">Operaciones Reparadas
      </div>
    </td>
    <td align="center" class="titulocolumnas">Operaciones Cursadas
      </div>
    </td>
    <td align="center" class="titulocolumnas">Total Cursado</td>
  </tr>
  <?php do { ?>
  <tr align="center" valign="middle">
    <td align="center"><?php echo $row_cantidad['evento']; ?></td>
    <td align="center"><strong><?php echo $row_cantidad['total']; ?></strong></td>
    <td align="center" class="destadado"><?php echo $row_cantidad['pendienteop']; ?></td>
    <td align="center" class="destadado"><?php echo $row_cantidad['pendientesup']; ?></td>
    <td align="center"><strong><?php echo $row_cantidad['reparadas']; ?></strong></td>
    <td align="center"><strong><?php echo $row_cantidad['cursado']; ?></strong></td>
    <td align="center"><?php echo $row_cantidad['reparadas'] + $row_cantidad['cursado']; ?></div></td>
  </tr>
  <?php } while ($row_cantidad = mysqli_fetch_assoc($cantidad)); ?>
</table>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../meco.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($cantidad);
?>