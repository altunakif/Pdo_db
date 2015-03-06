<?php
/* EXAMPLES OF INSERT */

// Class File
require 'class_pdo_db.php';

// Connection
//$db = new database('localhost', 'testdb', 'testuser', 'password');
$db = new database();

// Example 1
$db = new database();
$db->exec("insert [(email:adsoyad='akif', email= 'Başlık')]");
var_dump ($db->result);
var_dump ($db->sql);
/*
									- Screen Output -
array (size=1)
  0 => string 'INSERT INTO email (adsoyad,  email) VALUES ('akif',  'Başlık') (true)' (length=71)
array (size=1)
  0 => string 'INSERT INTO email (adsoyad,  email) VALUES ('akif',  'Başlık') ' (length=65)
  	
*/

// Example 2
$db = new database();
/* Birden fazla tabloya insert yapmak için */
$db->exec("insert [(email:adsoyad='akif', email= 'Başlık'), (haberler:baslik='baslik', icerik= 'icerik')]");
var_dump ($db->result);
var_dump ($db->sql);
/*
									- Screen Output -
array (size=2)
  0 => string 'INSERT INTO email (adsoyad,  email) VALUES ('akif',  'Başlık') (true)' (length=71)
  1 => string 'INSERT INTO haberler (baslik,  icerik) VALUES ('baslik',  'icerik') (true)' (length=74)
array (size=2)
  0 => string 'INSERT INTO email (adsoyad,  email) VALUES ('akif',  'Başlık') ' (length=65)
  1 => string 'INSERT INTO haberler (baslik,  icerik) VALUES ('baslik',  'icerik') ' (length=68)
  	
*/	

?>