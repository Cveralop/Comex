<?php
session_start();
$MM_authorizedUsers = "ADM,SUP";
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
$MM_restrictGoTo = "../estadistica/erroracceso.php";
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="shortcut icon" href="../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Estad&iacute;stica y Cuadro de Mando</title>
<style type="text/css">
<!--
@import url(../../cmando/estilos/estilo12.css);
@import url("../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #0000FF;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo1 {
	font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo2 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script src="../../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
</script>
<link href="../../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" bgcolor="#FF0000"><span class="Estilo1">ESTAD&Iacute;STICA Y CUADRO DE MANDO OPERACIONES</span></td>
    <td width="7%" align="left" valign="middle" bgcolor="#FF0000"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('999','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image8" width="80" height="25" border="0"></a>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Carta de Cr&eacute;dito de Importaci&oacute;n</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form1" method="post" action="">
                <span class="titulo_menu">
                <select name="menu3" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/opcci/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/opcci/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/opcci/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/opcci/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/opcci/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/opcci/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/opcci/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/opcci/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/opcci/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opcci/excepciones.php">Excepciones</option>
                  <option value="../estadistica/opcci/operacionesweb.php">Operaciones WEB Cursadas</option>
                  <br>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/opcci/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/opcci/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opcci/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/opcci/operacionesmae.php">Operaciones</option>
                </select>
                <input name="Button3" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel2" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Carta de Cr&eacute;dito de Exportaci&oacute;n</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form2" method="post" action="">
                <span class="titulo_menu">
                <select name="menu10" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/opcce/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/opcce/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/opcce/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/opcce/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/opcce/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/opcce/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/opcce/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/opcce/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/opcce/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opcce/excepciones.php">Excepciones</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/opcce/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/opcce/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opcce/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/opcce/operacionesmae.php">Operaciones</option>
                </select>
                <input name="Button10" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel3" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Cobranza Extranjera de Importaci&oacute;n y OPI</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><form name="form3" method="post" action="">
              <span class="titulo_menu">
              <select name="menu9" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                <option selected>Seleccione Una Opci&oacute;n</option>
                <option value="../estadistica/opcbi/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                <option value="../estadistica/opcbi/estadisticaxoperador.php">Estadistica por Operador </option>
                <option value="../estadistica/opcbi/factoriteraciones.php">Iteraciones (Factor)</option>
                <option value="../estadistica/opcbi/flujoxoperador.php">Flujo por Operador</option>
                <option value="../estadistica/opcbi/flujoxsupervisor.php">Flujo por Supervisor</option>
                <option value="../estadistica/opcbi/tiempocurse.php">Tiempo Curse</option>
                <option value="../estadistica/opcbi/reparosxespe.php">Reparos por Especialista</option>
                <option value="../estadistica/opcbi/opurgentes.php">Operaciones Urgentes</option>
                <option value="../estadistica/opcbi/opfuerahorario.php">Operaciones Fuera Horario</option>
                <option value="../estadistica/opcbi/excepciones.php">Excepciones</option>
                <option>*** Archivos Excel***</option>
                <option value="../estadistica/opcbi/opcursadasmae.php">Operaciones Ingresadas</option>
                <option value="../estadistica/opcbi/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                <option value="../estadistica/opcbi/opreparadasmae.php">Operaciones Reparadas</option>
                <option value="../estadistica/opcbi/operacionesmae.php">Operaciones</option>
              </select>
              <input name="Button9" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
              </span>
            </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel4" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Cobranza Extranjera de Exportaci&oacute;n</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form4" method="post" action="">
                <span class="titulo_menu">
                <select name="menu8" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/opcbe/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/opcbe/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/opcbe/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/opcbe/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/opcbe/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/opcbe/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/opcbe/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/opcbe/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/opcbe/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opcbe/excepciones.php">Excepciones</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/opcbe/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/opcbe/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opcbe/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/opcbe/operacionesmae.php">Operaciones</option>
                </select>
                <input name="Button8" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel5" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Pr&eacute;stamos</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form5" method="post" action="">
                <span class="titulo_menu">
                <select name="menu11" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/oppre/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/oppre/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/oppre/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/oppre/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/oppre/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/oppre/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/oppre/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/oppre/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/oppre/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/oppre/excepciones.php">Excepciones</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/oppre/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/oppre/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/oppre/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/oppre/operacionesmae.php">Operaciones</option>
                </select>
                <input name="Button11" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel6" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Mercado de Corredores</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form6" method="post" action="">
                <span class="titulo_menu">
                <select name="menu5" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/opmec/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/opmec/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/opmec/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/opmec/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/opmec/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/opmec/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/opmec/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/opmec/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/opmec/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opmec/excepciones.php">Excepciones</option>
                  <option value="../estadistica/opmec/fasttrack.php">Fast Track</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/opmec/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/opmec/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opmec/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/opmec/operacionesmae.php">Operaciones</option>
                </select>
                <input name="Button5" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel7" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Boleta de Garant&iacute;a</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form7" method="post" action="">
                <span class="titulo_menu">
                <select name="menu" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/opbga/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/opbga/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/opbga/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/opbga/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/opbga/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/opbga/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/opbga/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/opbga/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/opbga/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opbga/excepciones.php">Excepciones</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/opbga/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/opbga/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opbga/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/opbga/operacionesmae.php">Operaciones</option>
                </select>
                </span>
                <span class="titulo_menu">
                <input name="Button" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel8" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Stand BY Emitidas</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form8" method="post" action="">
                <span class="titulo_menu">
                <select name="menu2" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/opste/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/opste/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/opste/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/opste/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/opste/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/opste/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/opste/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/opste/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/opste/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opste/excepciones.php">Excepciones</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/opste/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/opste/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opste/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/opste/operacionesmae.php">Operaciones</option>
                </select>
                <input name="Button2" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel9" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Stand BY Recibidas</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form9" method="post" action="">
                <span class="titulo_menu">
                <select name="menu4" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/opstr/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/opstr/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/opstr/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/opstr/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/opstr/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/opstr/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/opstr/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/opstr/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/opstr/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opstr/excepciones.php">Excepciones</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/opstr/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/opstr/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opstr/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/opstr/operacionessmae.php">Operaciones</option>
                </select>
                <input name="Button4" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel10" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">Otros (Cr&eacute;ditos Externos, Capitulo XII, Capitulo XIV, DL600)</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form10" method="post" action="">
                <span class="titulo_menu">
                <select name="menu7" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/opcre/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/opcre/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/opcre/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/opcre/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/opcre/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/opcre/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/opcre/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/opcre/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/opcre/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opcre/excepciones.php">Excepciones</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/opcre/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/opcre/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/opcre/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/opcre/operacionesmae.php">Operaciones</option>
                </select>
                <input name="Button7" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
  <tr>
    <td><div id="CollapsiblePanel11" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">III B5</div>
      <div class="CollapsiblePanelContent">
        <table width="100%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td align="center" valign="middle"><span class="titulo_menu">
              </span>
              <form name="form11" method="post" action="">
                <span class="titulo_menu">
                <select name="menu6" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Opci&oacute;n</option>
                  <option value="../estadistica/optbc/cantidadopcursadas.php">Cantidad Operaciones Cursadas</option>
                  <option value="../estadistica/optbc/estadisticaxoperador.php">Estadistica por Operador </option>
                  <option value="../estadistica/optbc/factoriteraciones.php">Iteraciones (Factor)</option>
                  <option value="../estadistica/optbc/flujoxoperador.php">Flujo por Operador</option>
                  <option value="../estadistica/optbc/flujoxsupervisor.php">Flujo por Supervisor</option>
                  <option value="../estadistica/optbc/tiempocurse.php">Tiempo Curse</option>
                  <option value="../estadistica/optbc/reparosxespe.php">Reparos por Especialista</option>
                  <option value="../estadistica/optbc/opurgentes.php">Operaciones Urgentes</option>
                  <option value="../estadistica/optbc/opfuerahorario.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/optbc/excepciones.php">Excepciones</option>
                  <option>*** Archivos Excel***</option>
                  <option value="../estadistica/optbc/opcursadasmae.php">Operaciones Ingresadas</option>
                  <option value="../estadistica/optbc/opfuerahorariomae.php">Operaciones Fuera Horario</option>
                  <option value="../estadistica/optbc/opreparadasmae.php">Operaciones Reparadas</option>
                  <option value="../estadistica/optbc/operacionesmae.php">Operaciones</option>
                </select>
                <input name="Button6" type="button" class="boton" onClick="MM_jumpMenuGo('menu3','parent',1)" value="Ir">
                </span>
              </form></td>
          </tr>
        </table>
      </div>
    </div></td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>  </tr>
</table>
<script type="text/javascript">
<!--
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {contentIsOpen:false});
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3", {contentIsOpen:false});
var CollapsiblePanel4 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel4", {contentIsOpen:false});
var CollapsiblePanel5 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel5", {contentIsOpen:false});
var CollapsiblePanel6 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel6", {contentIsOpen:false});
var CollapsiblePanel7 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel7", {contentIsOpen:false});
var CollapsiblePanel8 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel8", {contentIsOpen:false});
var CollapsiblePanel9 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel9", {contentIsOpen:false});
var CollapsiblePanel10 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel10", {contentIsOpen:false});
var CollapsiblePanel11 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel11", {contentIsOpen:false});
//-->
</script>
</body>
</html>