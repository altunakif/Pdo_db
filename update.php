﻿<?php
/* EXAMPLES OF UPDATE */

// Class File
require 'class_pdo_db.php';

// Connection
//$db = new database('localhost', 'testdb', 'testuser', 'password');
$db = new database();

// Example 1
$db = new database();
$db->exec("uPdaTe [(email:adsoyad='Akif ALTUN', mesaj= 'Deneme Başlık')]
			Where [(id = 50)]");

var_dump ($db->result);
var_dump ($db->sql);
/*
									- Screen Output -
array (size=1)
  0 => string 'UPDATE email SET adsoyad='Akif ALTUN',  mesaj= 'Deneme Başlık' Where  (id = 50)(true)' (length=87)
array (size=1)
  0 => string 'UPDATE email SET adsoyad='Akif ALTUN',  mesaj= 'Deneme Başlık' Where  (id = 50)' (length=81)									
*/

// Example 2
$db = new database();
$db->exec("uPdaTe [(email:adsoyad='akif', mesaj= 'Başlık'), (haberler:baslik='baslik', icerik= 'icerik')]
			Where [(id = 50)]");

var_dump ($db->result);
var_dump ($db->sql);
/*
									- Screen Output -
array (size=2)
  0 => string 'UPDATE email SET adsoyad='akif',  mesaj= 'Başlık' Where  (id = 50)(true)' (length=74)
  1 => string 'UPDATE haberler SET baslik='baslik',  icerik= 'icerik' Where  (id = 50)(true)' (length=77)
array (size=2)
  0 => string 'UPDATE email SET adsoyad='akif',  mesaj= 'Başlık' Where  (id = 50)' (length=68)
  1 => string 'UPDATE haberler SET baslik='baslik',  icerik= 'icerik' Where  (id = 50)' (length=71)								
*/
?>