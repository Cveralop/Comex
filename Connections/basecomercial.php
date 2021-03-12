<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

//Conexion base de datos en azure
 $hostname_basecomercial = 'comexdbtest.mysql.database.azure.com';
 $database_basecomercial = "basecomercial";
 $username_basecomercial = 'xmsadmin@comexdbtest';
 $password_basecomercial = 'Microsoft01*';

 $basecomercial = mysqli_init();
 mysqli_ssl_set($basecomercial,NULL,NULL, "/home/site/wwwroot/Connections/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);
 mysqli_real_connect($basecomercial, $hostname_basecomercial, $username_basecomercial, $password_basecomercial, $database_basecomercial, 3306, MYSQLI_CLIENT_SSL);
 if (mysqli_connect_errno($basecomercial)) {
 die('Failed to connect to MySQL: '.mysqli_connect_error());
 }


//Conexion base de datos Local
// $hostname_basecomercial = 'localhost';
// $database_basecomercial = "basecomercial";
// $username_basecomercial = 'root';
// $password_basecomercial = '';

//conexion nueva
// $basecomercial = new mysqli($hostname_basecomercial, $username_basecomercial, $password_basecomercial,
// $database_basecomercial);

// Check connection
// if ($basecomercial->connect_error) {
//     die("Connection failed: " . $basecomercial->connect_error);
//   }
?>
