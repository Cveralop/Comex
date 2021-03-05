<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  global $comercioexterior;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($comercioexterior, $theValue) : mysqli_escape_string($comercioexterior, $theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_opbga = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opbga = $_GET['date_ini'];
}
$colname1_opbga = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opbga = $_GET['date_fin'];
}
$colname2_opbga = "Boleta de Garantia";
if (isset($_GET['producto'])) {
  $colname2_opbga = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opbga = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opbga, "date"),GetSQLValueString($colname1_opbga, "date"),GetSQLValueString($colname2_opbga, "text"));
$opbga = mysqli_query($comercioexterior, $query_opbga) or die(mysqli_error($comercioexterior));
$row_opbga = mysqli_fetch_assoc($opbga);
$totalRows_opbga = mysqli_num_rows($opbga);

$colname_sumbga = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumbga = $_GET['date_ini'];
}
$colname1_sumbga = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumbga = $_GET['date_fin'];
}
$colname2_sumbga = "Boleta de Garantia";
if (isset($_GET['producto'])) {
  $colname2_sumbga = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumbga = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumbga, "date"),GetSQLValueString($colname1_sumbga, "date"),GetSQLValueString($colname2_sumbga, "text"));
$sumbga = mysqli_query($comercioexterior, $query_sumbga) or die(mysqli_error($comercioexterior));
$row_sumbga = mysqli_fetch_assoc($sumbga);
$totalRows_sumbga = mysqli_num_rows($sumbga);

$colname_opcce = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opcce = $_GET['date_ini'];
}
$colname1_opcce = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opcce = $_GET['date_fin'];
}
$colname2_opcce = "Carta de Credito Export";
if (isset($_GET['producto'])) {
  $colname2_opcce = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcce = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opcce, "date"),GetSQLValueString($colname1_opcce, "date"),GetSQLValueString($colname2_opcce, "text"));
$opcce = mysqli_query($comercioexterior, $query_opcce) or die(mysqli_error($comercioexterior));
$row_opcce = mysqli_fetch_assoc($opcce);
$totalRows_opcce = mysqli_num_rows($opcce);

$colname_sumcce = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcce = $_GET['date_ini'];
}
$colname1_sumcce = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcce = $_GET['date_fin'];
}
$colname2_sumcce = "Carta de Credito Export";
if (isset($_GET['producto'])) {
  $colname2_sumcce = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcce = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumcce, "date"),GetSQLValueString($colname1_sumcce, "date"),GetSQLValueString($colname2_sumcce, "text"));
$sumcce = mysqli_query($comercioexterior, $query_sumcce) or die(mysqli_error($comercioexterior));
$row_sumcce = mysqli_fetch_assoc($sumcce);
$totalRows_sumcce = mysqli_num_rows($sumcce);

$colname_opcci = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opcci = $_GET['date_ini'];
}
$colname1_opcci = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opcci = $_GET['date_fin'];
}
$colname2_opcci = "Carta de Credito Import";
if (isset($_GET['producto'])) {
  $colname2_opcci = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opcci, "date"),GetSQLValueString($colname1_opcci, "date"),GetSQLValueString($colname2_opcci, "text"));
$opcci = mysqli_query($comercioexterior, $query_opcci) or die(mysqli_error($comercioexterior));
$row_opcci = mysqli_fetch_assoc($opcci);
$totalRows_opcci = mysqli_num_rows($opcci);

$colname_sumcci = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcci = $_GET['date_ini'];
}
$colname1_sumcci = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcci = $_GET['date_fin'];
}
$colname2_sumcci = "Carta de Credito Import";
if (isset($_GET['producto'])) {
  $colname2_sumcci = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcci = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumcci, "date"),GetSQLValueString($colname1_sumcci, "date"),GetSQLValueString($colname2_sumcci, "text"));
$sumcci = mysqli_query($comercioexterior, $query_sumcci) or die(mysqli_error($comercioexterior));
$row_sumcci = mysqli_fetch_assoc($sumcci);
$totalRows_sumcci = mysqli_num_rows($sumcci);

$colname_opcdpo = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opcdpo = $_GET['date_ini'];
}
$colname1_opcdpo = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opcdpo = $_GET['date_fin'];
}
$colname2_opcdpo = "Cecion Derecho/Pago Anti";
if (isset($_GET['producto'])) {
  $colname2_opcdpo = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcdpo = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opcdpo, "date"),GetSQLValueString($colname1_opcdpo, "date"),GetSQLValueString($colname2_opcdpo, "text"));
$opcdpo = mysqli_query($comercioexterior, $query_opcdpo) or die(mysqli_error($comercioexterior));
$row_opcdpo = mysqli_fetch_assoc($opcdpo);
$totalRows_opcdpo = mysqli_num_rows($opcdpo);

$colname_opcbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opcbe = $_GET['date_ini'];
}
$colname1_opcbe = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opcbe = $_GET['date_fin'];
}
$colname2_opcbe = "Cobranza Extranjera de Export";
if (isset($_GET['producto'])) {
  $colname2_opcbe = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbe = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opcbe, "date"),GetSQLValueString($colname1_opcbe, "date"),GetSQLValueString($colname2_opcbe, "text"));
$opcbe = mysqli_query($comercioexterior, $query_opcbe) or die(mysqli_error($comercioexterior));
$row_opcbe = mysqli_fetch_assoc($opcbe);
$totalRows_opcbe = mysqli_num_rows($opcbe);

$colname_sumcbe = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcbe = $_GET['date_ini'];
}
$colname1_sumcbe = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcbe = $_GET['date_fin'];
}
$colname2_sumcbe = "Cobranza Extranjera de Export";
if (isset($_GET['producto'])) {
  $colname2_sumcbe = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcbe = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumcbe, "date"),GetSQLValueString($colname1_sumcbe, "date"),GetSQLValueString($colname2_sumcbe, "text"));
$sumcbe = mysqli_query($comercioexterior, $query_sumcbe) or die(mysqli_error($comercioexterior));
$row_sumcbe = mysqli_fetch_assoc($sumcbe);
$totalRows_sumcbe = mysqli_num_rows($sumcbe);

$colname_opcbi = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opcbi = $_GET['date_ini'];
}
$colname1_opcbi = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opcbi = $_GET['date_fin'];
}
$colname2_opcbi = "Cobranza Extranjera de Import";
if (isset($_GET['producto'])) {
  $colname2_opcbi = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcbi = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opcbi, "date"),GetSQLValueString($colname1_opcbi, "date"),GetSQLValueString($colname2_opcbi, "text"));
$opcbi = mysqli_query($comercioexterior, $query_opcbi) or die(mysqli_error($comercioexterior));
$row_opcbi = mysqli_fetch_assoc($opcbi);
$totalRows_opcbi = mysqli_num_rows($opcbi);

$colname_sumcbi = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcbi = $_GET['date_ini'];
}
$colname1_sumcbi = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcbi = $_GET['date_fin'];
}
$colname2_sumcbi = "Cobranza Extranjera de Import";
if (isset($_GET['producto'])) {
  $colname2_sumcbi = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcbi = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumcbi, "date"),GetSQLValueString($colname1_sumcbi, "date"),GetSQLValueString($colname2_sumcbi, "text"));
$sumcbi = mysqli_query($comercioexterior, $query_sumcbi) or die(mysqli_error($comercioexterior));
$row_sumcbi = mysqli_fetch_assoc($sumcbi);
$totalRows_sumcbi = mysqli_num_rows($sumcbi);

$colname_optbc = "-1";
if (isset($_GET['date_ini'])) {
  $colname_optbc = $_GET['date_ini'];
}
$colname1_optbc = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_optbc = $_GET['date_fin'];
}
$colname2_optbc = "Credito IIIB5";
if (isset($_GET['producto'])) {
  $colname2_optbc = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_optbc = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_optbc, "date"),GetSQLValueString($colname1_optbc, "date"),GetSQLValueString($colname2_optbc, "text"));
$optbc = mysqli_query($comercioexterior, $query_optbc) or die(mysqli_error($comercioexterior));
$row_optbc = mysqli_fetch_assoc($optbc);
$totalRows_optbc = mysqli_num_rows($optbc);

$colname_sumtbc = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumtbc = $_GET['date_ini'];
}
$colname1_sumtbc = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumtbc = $_GET['date_fin'];
}
$colname2_sumtbc = "Credito IIIB5";
if (isset($_GET['producto'])) {
  $colname2_sumtbc = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumtbc = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumtbc, "date"),GetSQLValueString($colname1_sumtbc, "date"),GetSQLValueString($colname2_sumtbc, "text"));
$sumtbc = mysqli_query($comercioexterior, $query_sumtbc) or die(mysqli_error($comercioexterior));
$row_sumtbc = mysqli_fetch_assoc($sumtbc);
$totalRows_sumtbc = mysqli_num_rows($sumtbc);

$colname_opcex = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opcex = $_GET['date_ini'];
}
$colname1_opcex = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opcex = $_GET['date_fin'];
}
$colname2_opcex = "DL600-CapXIII-CAPXIV";
if (isset($_GET['producto'])) {
  $colname2_opcex = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcex = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opcex, "date"),GetSQLValueString($colname1_opcex, "date"),GetSQLValueString($colname2_opcex, "text"));
$opcex = mysqli_query($comercioexterior, $query_opcex) or die(mysqli_error($comercioexterior));
$row_opcex = mysqli_fetch_assoc($opcex);
$totalRows_opcex = mysqli_num_rows($opcex);

$colname_sumcex = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumcex = $_GET['date_ini'];
}
$colname1_sumcex = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumcex = $_GET['date_fin'];
}
$colname2_sumcex = "DL600-CapXIII-CAPXIV";
if (isset($_GET['producto'])) {
  $colname2_sumcex = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumcex = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumcex, "date"),GetSQLValueString($colname1_sumcex, "date"),GetSQLValueString($colname2_sumcex, "text"));
$sumcex = mysqli_query($comercioexterior, $query_sumcex) or die(mysqli_error($comercioexterior));
$row_sumcex = mysqli_fetch_assoc($sumcex);
$totalRows_sumcex = mysqli_num_rows($sumcex);

$colname_opste = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opste = $_GET['date_ini'];
}
$colname1_opste = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opste = $_GET['date_fin'];
}
$colname2_opste = "L/C Stand By Emitida";
if (isset($_GET['producto'])) {
  $colname2_opste = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opste = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opste, "date"),GetSQLValueString($colname1_opste, "date"),GetSQLValueString($colname2_opste, "text"));
$opste = mysqli_query($comercioexterior, $query_opste) or die(mysqli_error($comercioexterior));
$row_opste = mysqli_fetch_assoc($opste);
$totalRows_opste = mysqli_num_rows($opste);

$colname_sumste = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumste = $_GET['date_ini'];
}
$colname1_sumste = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumste = $_GET['date_fin'];
}
$colname2_sumste = "L/C Stand By Emitida";
if (isset($_GET['producto'])) {
  $colname2_sumste = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumste = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumste, "date"),GetSQLValueString($colname1_sumste, "date"),GetSQLValueString($colname2_sumste, "text"));
$sumste = mysqli_query($comercioexterior, $query_sumste) or die(mysqli_error($comercioexterior));
$row_sumste = mysqli_fetch_assoc($sumste);
$totalRows_sumste = mysqli_num_rows($sumste);

$colname_opstr = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opstr = $_GET['date_ini'];
}
$colname1_opstr = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opstr = $_GET['date_fin'];
}
$colname2_opstr = "L/C Stand By Recibida";
if (isset($_GET['producto'])) {
  $colname2_opstr = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opstr = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opstr, "date"),GetSQLValueString($colname1_opstr, "date"),GetSQLValueString($colname2_opstr, "text"));
$opstr = mysqli_query($comercioexterior, $query_opstr) or die(mysqli_error($comercioexterior));
$row_opstr = mysqli_fetch_assoc($opstr);
$totalRows_opstr = mysqli_num_rows($opstr);

$colname_sumstr = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumstr = $_GET['date_ini'];
}
$colname1_sumstr = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumstr = $_GET['date_fin'];
}
$colname2_sumstr = "L/C Stand By Recibida";
if (isset($_GET['producto'])) {
  $colname2_sumstr = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumstr = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumstr, "date"),GetSQLValueString($colname1_sumstr, "date"),GetSQLValueString($colname2_sumstr, "text"));
$sumstr = mysqli_query($comercioexterior, $query_sumstr) or die(mysqli_error($comercioexterior));
$row_sumstr = mysqli_fetch_assoc($sumstr);
$totalRows_sumstr = mysqli_num_rows($sumstr);

$colname_opmec = "-1";
if (isset($_GET['date_ini'])) {
  $colname_opmec = $_GET['date_ini'];
}
$colname1_opmec = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_opmec = $_GET['date_fin'];
}
$colname2_opmec = "Mercado Corredores";
if (isset($_GET['producto'])) {
  $colname2_opmec = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opmec = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_opmec, "date"),GetSQLValueString($colname1_opmec, "date"),GetSQLValueString($colname2_opmec, "text"));
$opmec = mysqli_query($comercioexterior, $query_opmec) or die(mysqli_error($comercioexterior));
$row_opmec = mysqli_fetch_assoc($opmec);
$totalRows_opmec = mysqli_num_rows($opmec);

$colname_summec = "-1";
if (isset($_GET['date_ini'])) {
  $colname_summec = $_GET['date_ini'];
}
$colname1_summec = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_summec = $_GET['date_fin'];
}
$colname2_summec = "Mercado Corredores";
if (isset($_GET['producto'])) {
  $colname2_summec = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_summec = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_summec, "date"),GetSQLValueString($colname1_summec, "date"),GetSQLValueString($colname2_summec, "text"));
$summec = mysqli_query($comercioexterior, $query_summec) or die(mysqli_error($comercioexterior));
$row_summec = mysqli_fetch_assoc($summec);
$totalRows_summec = mysqli_num_rows($summec);

$colname_oppre = "-1";
if (isset($_GET['date_ini'])) {
  $colname_oppre = $_GET['date_ini'];
}
$colname1_oppre = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_oppre = $_GET['date_fin'];
}
$colname2_oppre = "Prestamos Stand Alone";
if (isset($_GET['producto'])) {
  $colname2_oppre = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_oppre = sprintf("SELECT *,SUM(nro_cuotas)as nroop, MIN(date_curse)as fini, MAX(date_curse)as ffin FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY segmento_comercial ORDER BY nroop DESC", GetSQLValueString($colname_oppre, "date"),GetSQLValueString($colname1_oppre, "date"),GetSQLValueString($colname2_oppre, "text"));
$oppre = mysqli_query($comercioexterior, $query_oppre) or die(mysqli_error($comercioexterior));
$row_oppre = mysqli_fetch_assoc($oppre);
$totalRows_oppre = mysqli_num_rows($oppre);

$colname_sumpre = "-1";
if (isset($_GET['date_ini'])) {
  $colname_sumpre = $_GET['date_ini'];
}
$colname1_sumpre = "-1";
if (isset($_GET['date_fin'])) {
  $colname1_sumpre = $_GET['date_fin'];
}
$colname2_sumpre = "Prestamos Stand Alone";
if (isset($_GET['producto'])) {
  $colname2_sumpre = $_GET['producto'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_sumpre = sprintf("SELECT *,SUM(nro_cuotas)as total FROM cm_opxseg WHERE date_curse BETWEEN %s AND %s AND producto = %s AND segmento_comercial <> 'Sin Dato' GROUP BY producto", GetSQLValueString($colname_sumpre, "date"),GetSQLValueString($colname1_sumpre, "date"),GetSQLValueString($colname2_sumpre, "text"));
$sumpre = mysqli_query($comercioexterior, $query_sumpre) or die(mysqli_error($comercioexterior));
$row_sumpre = mysqli_fetch_assoc($sumpre);
$totalRows_sumpre = mysqli_num_rows($sumpre);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nro Operaciones por Segmento</title>
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
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script type="text/javascript">
/*<!--
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
//-->*/
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">NRO OPERACIONES POR SEGMENTO</span></td>
    <td width="21%" align="right" valign="middle"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
      <param name="movie" value="../../imagenes/SWF/reloj_3.swf" />
      <param name="quality" value="high" />
      <embed src="../../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
    </object>
      </div></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../estadistica_operaciones.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen2','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen2" width="80" height="25" border="0" id="Imagen2" /></a></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulodetalle">Busqueda por Rango de Fecha</span></td>
    </tr>
    <tr>
      <td width="20%" align="right" valign="middle">Fecha Curse:</td>
      <td width="80%" align="left" valign="middle"><span class="respuestacolumna_rojo">Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
      <span class="respuestacolumna_rojo">Hasta</span>        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<?php if ($totalRows_opcci > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opcci['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opcci['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opcci['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcci['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opcci['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumcci['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
  <br />
<?php if ($totalRows_opcce > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opcce['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opcce['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opcce['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcce['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opcce['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcce = mysqli_fetch_assoc($opcce)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumcce['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbi > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opcbi['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opcbi['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opcbi['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcbi['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opcbi['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcbi = mysqli_fetch_assoc($opcbi)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumcbi['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcbe > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opcbe['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opcbe['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opcbe['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcbe['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opcbe['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcbe = mysqli_fetch_assoc($opcbe)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumcbe['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opmec > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opmec['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opmec['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opmec['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opmec['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opmec['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opmec = mysqli_fetch_assoc($opmec)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_summec['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_oppre > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"> <img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_oppre['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_oppre['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_oppre['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_oppre['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_oppre['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_oppre = mysqli_fetch_assoc($oppre)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumpre['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opste > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opste['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opste['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opste['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opste['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opste['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opste = mysqli_fetch_assoc($opste)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumste['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opstr > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opstr['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opstr['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opstr['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opstr['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opstr['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opstr = mysqli_fetch_assoc($opstr)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumstr['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opbga > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opbga['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opbga['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opbga['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opbga['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opbga['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opbga = mysqli_fetch_assoc($opbga)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumbga['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_optbc > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_optbc['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_optbc['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_optbc['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_optbc['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_optbc['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_optbc = mysqli_fetch_assoc($optbc)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumtbc['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
<br />
<?php if ($totalRows_opcex > 0) { // Show if recordset not empty ?>
  <table width="70%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" />Servicio <span class="tituloverde"><?php echo $row_opcex['producto']; ?></span> Desde <span class="tituloverde"><?php echo $row_opcex['fini']; ?></span> Hasta <span class="tituloverde"><?php echo $row_opcex['ffin']; ?></span></td>
    </tr>
    <tr>
      <td width="70%" align="center" valign="middle" class="titulocolumnas">Segmento</td>
      <td width="30%" align="center" valign="middle" class="titulocolumnas">Nro de Operaciones por Segmento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="left" valign="middle" class="respuestacolumna_azul"><?php echo $row_opcex['segmento_comercial']; ?></td>
        <td align="right" valign="middle" class="respuestacolumna_azul"><?php echo number_format($row_opcex['nroop'], 0, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_opcex = mysqli_fetch_assoc($opcex)); ?>
    <tr>
      <td align="left" valign="middle" class="respuestacolumna_azul">Total</td>
      <td align="right" valign="middle" class="respuestacolumna_rojo"><?php echo number_format($row_sumcex['total'], 0, ',', '.'); ?></td>
    </tr>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($opbga);
mysqli_free_result($opcce);
mysqli_free_result($opcci);
mysqli_free_result($opcdpo);
mysqli_free_result($opcbe);
mysqli_free_result($opcbi);
mysqli_free_result($optbc);
mysqli_free_result($opcex);
mysqli_free_result($opste);
mysqli_free_result($opstr);
mysqli_free_result($opmec);
mysqli_free_result($oppre);
?>