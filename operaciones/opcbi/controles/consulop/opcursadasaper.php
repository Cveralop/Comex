<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE,GER";
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
$colname2_cursada = "1";
if (isset($_GET['fecha_curse'])) {
  $colname2_cursada = (get_magic_quotes_gpc()) ? $_GET['fecha_curse'] : addslashes($_GET['fecha_curse']);
}
$colname1_cursada = "1";
if (isset($_GET['estado'])) {
  $colname1_cursada = (get_magic_quotes_gpc()) ? $_GET['estado'] : addslashes($_GET['estado']);
}
$colname_cursada = "1";
if (isset($_GET['evento'])) {
  $colname_cursada = (get_magic_quotes_gpc()) ? $_GET['evento'] : addslashes($_GET['evento']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cursada = sprintf("SELECT * FROM opcbi WHERE evento LIKE '%%%s%%' and estado LIKE '%%%s%%' and fecha_curse LIKE '%%%s%%' ORDER BY id DESC", $colname_cursada,$colname1_cursada,$colname2_cursada);
$cursada = mysqli_query($comercioexterior, $query_cursada) or die(mysqli_error());
$row_cursada = mysqli_fetch_assoc($cursada);
$totalRows_cursada = mysqli_num_rows($cursada);
?>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
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
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo6 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo10 {color: #00FF00}
.Estilo11 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo12 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style><title>Operaciones Cursadas</title>
<script language="JavaScript" type="text/JavaScript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3"> OPERACIONES CURSADAS</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COBRANZA DE IMPORTACI&Oacute;N y OPI </td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="6" align="left" valign="middle"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Estado Operaciones</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Fecha Curse:</td>
      <td align="center" valign="middle">
        <input name="fecha_curse" type="text" class="etiqueta12" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
        <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="center" valign="middle">
        <select name="evento" class="etiqueta12" id="evento">
          <option value="Apertura." selected>Apertura</option>
          <option value="Aceptacion.">Aceptacion</option>
          <option value="Carta Compromiso.">Carta Compromiso</option>
          <option value="Modificacion.">Modificacion</option>
          <option value="MSG-Swift.">MSG-Swift</option>
          <option value="Pago.">Pago</option>
          <option value="Protesto.">Protesto</option>
          <option value="Visacion.">Visacion (DI)</option>
          <option value=".">Todas</option>
        </select>
      </div></td>
      <td align="right" valign="middle">Estado:</div></td>
      <td align="center" valign="middle">
        <select name="estado" class="etiqueta12" id="estado">
          <option value="Cursada." selected>Cursada</option>
          <option value="Pendiente.">Pendiente</option>
          <option value="Reparada.">Reparada</option>
          <option value=".">Todas</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td colspan="6" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../cobimport.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_cursada > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="11" align="left" valign="middle"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Total Operaciones <span class="Estilo10"><?php echo $totalRows_cursada ?></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Operador</span></div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado
      </div>      
      </div>      
      </td>
    <td align="center" valign="middle" class="titulocolumnas">Observaciones
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"> <span class="respuestacolumna_rojo"><?php echo strtoupper($row_cursada['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_cursada['fecha_ingreso']; ?> </div></td>
    <td align="center" valign="middle"><?php echo $row_cursada['fecha_curse']; ?> </div></td>
    <td align="center" valign="middle"><?php echo $row_cursada['rut_cliente']; ?> </div></td>
    <td align="left" valign="middle"><?php echo $row_cursada['nombre_cliente']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cursada['operador']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_cursada['evento']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_cursada['estado']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cursada['obs']; ?>&nbsp; </td>
    <td align="center" valign="middle"><?php echo strtoupper($row_cursada['especialista']); ?></div></td>
    <td align="right" valign="middle">
      <span class="respuestacolumna_rojo"><?php echo strtoupper($row_cursada['moneda_operacion']); ?></span><span class="Estilo6"><span class="respuestacolumna_azul"> <?php echo number_format($row_cursada['monto_operacion'], 2, ',', '.'); ?></span></span>
      </div></td>
  </tr>
  <?php } while ($row_cursada = mysqli_fetch_assoc($cursada)); ?>
</table>
<strong> </strong><?php
mysqli_free_result($cursada);
?>
<?php } // Show if recordset not empty ?>