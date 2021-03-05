<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM";
$MM_donotCheckaccess = "false";
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
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
$MM_restrictGoTo = "erroracceso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
    $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: " . $MM_restrictGoTo);
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Desarrollo de Productos NI</title>
  <style type="text/css">
    <!--
    @import url("../estilos/estilo12.css");

    body,
    td,
    th {
      font-family: Verdana, Arial, Helvetica, sans-serif;
      font-size: 10px;
      color: #0000FF;
    }

    body {
      background-image: url(../imagenes/JPEG/edificio_corporativo.jpg);
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

    .Estilo3 {
      font-size: 24px;
      color: #FFFFFF;
      font-weight: bold;
    }

    .Estilo6 {
      color: #FFFFFF;
      font-weight: bold;
    }

    .Estilo4 {
      font-size: 12px;
      font-weight: bold;
      color: #FFFFFF;
    }

    .Estilo7 {
      font-size: 10px
    }

    .Estilo8 {
      font-size: 10px;
      font-weight: bold;
      color: #FFFFFF;
    }

    .Estilo9 {
      color: #CCCCCC
    }

    .Estilo10 {
      color: #0000FF
    }
    -->
  </style>
  <script>
    //Script original de KarlanKas para forosdelweb.com 
    var segundos = 1200
    var direccion = 'http://pdpto38:8303/comex/index.php'
    milisegundos = segundos * 1000
    window.setTimeout("window.location.replace(direccion);", milisegundos);
  </script>
</head>

<body onLoad="MM_preloadImages('../imagenes/Botones/boton_volver_2.jpg')">
  <table width="95%" border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
    <tr>
      <td width="5%" valign="middle"><img src="../imagenes/GIF/erde016.gif" width="43" height="43" align="left"></td>
      <td width="70%" align="left" valign="middle"><span class="Estilo3">DESARROLLO DE PRODUCTOS NI</span></td>
      <td width="25%" valign="middle">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60" align="right">
          <param name="movie" value="../imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="../imagenes/SWF/reloj_3.swf" width="250" height="60" align="right" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
        </object>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <table width="95%" border="0" align="center">
    <tr>
      <td align="right" valign="middle"><a href="../ingreso.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <table width="95%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td bordercolor="#000000">
        <br>
        <table width="90%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" colspan="2" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Subida de Archivos y Carga de Archivos para Procesos</span></td>
          </tr>
          <td width="50%" align="center" valign="middle" bgcolor="#FFFF00" class="NegrillaCartaReparo">Subir Archivos
          <td width="50%" align="center" valign="middle" bgcolor="#FFFF00" class="NegrillaCartaReparo">Carga de Archivos para Procesos</td>
    </tr>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/subirsac.php">Subir SAC</a>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/cargasac.php">Cargar Archivo SAC</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/subircontestabilidad.php">Subir Contestabilidad Diaria</a></td>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/cargarcontestabilidad.php">Cargar Contestabilidad Diaria</a></td>
    </tr>
    <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/subirtipocambio.php">Subir Archivo Tipo Cambio (Mensual)</a></td>

    <td align="left" valign="middle" bgcolor="#CCCCCC"><span class="NegrillaCartaReparo"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"></span><a href="tareas_manuales/cargartipocambio.php">Cargar Tipo de Cambio</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/subiroprecibidas.php">Subir OP Recibidas</a></td>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/cargaroprecibidas.php">Cargar OP Recibidas</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/subiropenviadas.php">Subir OP Enviadas</a></td>
      <td align="left" valign="middle" bgcolor="#CCCCCC"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="tareas_manuales/cargaropenviadas.php">Cargar OP Enviadas</a></td>
    </tr>
  </table>
  <br>
  <table width="90%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td height="19" colspan="2" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Informes de Gesti&oacute;n - Reportes</span></td>
    </tr>
    <tr>
      <td width="50%" align="center" valign="middle" bgcolor="#00FF00" class="NegrillaCartaReparo">Informes de Gesti&oacute;n Operaciones</td>
      <td width="50%" align="center" valign="middle" bgcolor="#00FF00" class="NegrillaCartaReparo">Informes de Gesti&oacute;n Post Venta</td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/cumplimiento_curse_operaciones_mae.php">Cumplimiento Curse Operaciones Diario</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/operaciones_postventa_mae.php">Operaciones Ingresadas por Post Venta Diario (TER - BEI)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/cumplimiento_curse_operaciones_mes_mae.php">Cumplimiento Curse Operaciones Mensual</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/operaciones_postventa_bmg_mae.php">Operaciones Ingresadas por Post Venta Diario (BMG)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/operaciones_reparadas_mae.php">Operaciones Reparadas</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/sacpendientes.php">SAC Pendientes</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/operaciones_fuera_horario_mae.php">Operaciones Fuera de Horario</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/caratulagoc_pend_acurec.php">Caratula GOC sin Acuse Recibo</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/cuadratura.php">Cuadratura Operaciones GOC v/s Subsidiario (BASE CUADRATURA)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/trazabilidad_operaciones_mae.php">Trasabilidad de Operaciones Detalle</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><a href="informegestion/operaciones_pendientes.php"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12" border="0">Operaciones Pendientes</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/trazabilidad_resumen_mae.php">Resumen Trazabilidad</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/operaciones_ingresadas_mae.php">Operaciones Ingresadas por Rango de Fecha</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="estadistica/estadistica_postventa_mae.php">Estadistica Post Venta Diaria o por Rango de Fecha</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="estadistica/estadistica_operaciones_mae.php">Estadistica Operaciones Diaria o por Rango de Fecha</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/operaciones_fuera_horario_mae.php">Resumen Estadistica Curse Operaciones</a></td>
    </tr>
  </table>
  <br>
  <table width="90%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td width="50%" height="19" align="left" valign="middle" bgcolor="#999900"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Control y Gesti&oacute;n de Usuarios GOC</span></td>
      <td width="50%" align="left" valign="middle" bgcolor="#999900"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Registro Log's de Procesos Automaticos y Manuales</span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="usuarios/ingreso.php">Creaci&oacute;n de Usuarios en GOC</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="logdeprocesos/logsprocesosautomaticos.php">Log's Procesos Automaticos</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="usuarios/modmae.php">Modificar Usuariso en GOC</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="logdeprocesos/logsprocesosmanuales.php">Log's Procesos Manuales</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="usuarios/consultamae.php">Consultar Usuario en GOC</a></td>
      <td align="left" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="accesousuarios/logacceso.php">Ver registro acceso Usuarios GOC</a></td>
      <td align="left" valign="middle">&nbsp;</td>
    </tr>
  </table>
  <br>
  <table width="90%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td height="19" colspan="2" align="left" valign="middle" bgcolor="#FF3300"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Informe Dashboard (Operaciones Nuevas)</span></td>
    </tr>
    <tr>
      <td width="50%" align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/panel_control_mae.php">DASHBOARD por Rango de Fechas (Total)</a></td>
      <td width="50%" align="left" valign="middle"><span class="Estilo4"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/ciclos_panel_control_mae.php">DASHBOARD por CICLOS Ultimos 3 Dias (Total)</a></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/panel_control_mae_bei.php">DASCHBOARD por Rango de Fecha (BEI)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/ciclos_panel_control_mae_bei.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BEI)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/panel_control_mae_bc.php">DASCHBOARD por Rango de Fecha (BCA Comercial)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/ciclos_panel_control_mae_bc.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BCA Comercial)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/panel_control_mae_bmg.php">DASCHBOARD por Rango de Fecha (BMG)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/ciclos_panel_control_mae_bmg.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BMG)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/panel_control_mae_pyme.php">DASCHBOARD por Rango de Fecha (PYME)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_nuevas_operaciones/ciclos_panel_control_mae_pyme.php">DASCHBOARD por CICLOS Ultimos 3 Dias (PYME)</a></td>
    </tr>
  </table>
  <br>
  <table width="90%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td height="19" colspan="2" align="left" valign="middle" bgcolor="#FF6600"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Informe Dashboard (Todos Los Eventos)</span></td>
    </tr>
    <tr>
      <td width="50%" align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/panel_control_mae.php">DASHBOARD por Rango de Fechas (Total)</a></td>
      <td width="50%" align="left" valign="middle"><span class="Estilo4"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/ciclos_panel_control_mae.php">DASHBOARD por CICLOS Ultimos 3 Dias (Total)</a></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/panel_control_mae_bei.php">DASCHBOARD por Rango de Fecha (BEI)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/ciclos_panel_control_mae_bei.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BEI)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/panel_control_mae_bc.php">DASCHBOARD por Rango de Fecha (BCA Comercial)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/ciclos_panel_control_mae_bc.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BCA Comercial)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/panel_control_mae_bmg.php">DASCHBOARD por Rango de Fecha (BMG)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/ciclos_panel_control_mae_bmg.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BMG)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/panel_control_mae_pyme.php">DASCHBOARD por Rango de Fecha (PYME)</a></td>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="dashboard_todoslos_eventos/ciclos_panel_control_mae_pyme.php">DASCHBOARD por CICLOS Ultimos 3 Dias (PYME)</a></td>
    </tr>
  </table>
  <br>
  <table width="90%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td height="19" align="left" valign="middle" bgcolor="#0000FF"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Linea de Gastos</span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="linea_gastos/linea_gastomae.php">Linea de Gastos (TOTAL)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="linea_gastos/linea_gastomae_bei.php">Linea de Gastos (BEI)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="linea_gastos/linea_gastomae_bc.php">Linea de Gastos (BCA Comercial)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="linea_gastos/linea_gastomae_bmg.php">Linea de Gastos (BMG)</a></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="linea_gastos/linea_gastomae_pyme.php">Linea de Gastos (PYME)</a></td>
    </tr>
  </table>
  <br></td>
  </tr>
  </table>
</body>

</html>