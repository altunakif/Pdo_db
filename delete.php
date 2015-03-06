<?php
/**
 * EXAMPLES OF DELETE
 * @author Akif ALTUN
 * @github https://github.com/altunakif
 * @mail altun_akif@hotmail.com
 * @phone +90 537 500 2090
 * @time Wednesday, 2 March 2015 09:47 (GMT + 2:00) Turkey
 * @update 06 March 2015 09:20 (GMT + 2:00) Turkey
*/

// Class File
require 'class_pdo_db.php';

// Connection
//$db = new database('localhost', 'testdb', 'testuser', 'password');
$db = new database();

// Example 1
$db = new database();
$db->exec("DEleTe [(email:id = 36)]");

var_dump ($db->result);
var_dump ($db->sql);
/*
									- Screen Output -
﻿
array (size=1)
  0 => string 'DELETE FROM email WHERE (id ) = (36) (true)' (length=43)
array (size=1)
  0 => string 'DELETE FROM email WHERE (id ) = (36) ' (length=37)									
*/

// Example 2
$db = new database();
/* Birden fazla tablodan veri silme */
$db->exec("DEleTe [(email:adsoyad='Sibel Pamuk'), (haberler:baslik='baslik')]");			

var_dump ($db->result);
var_dump ($db->sql);
/*
									- Screen Output -
﻿
array (size=2)
  0 => string 'DELETE FROM email WHERE (adsoyad) = ('Sibel Pamuk') (true)' (length=58)
  1 => string 'DELETE FROM haberler WHERE (baslik) = ('baslik') (true)' (length=55)
array (size=2)
  0 => string 'DELETE FROM email WHERE (adsoyad) = ('Sibel Pamuk') ' (length=52)
  1 => string 'DELETE FROM haberler WHERE (baslik) = ('baslik') ' (length=49)									
*/
?>