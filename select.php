<?php
/**
 * EXAMPLES OF SELECT
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
$db->exec("SELECT 	[(haberler:aid, baslik, link), (iller:ilid, Sehir, Plaka->inner, ON haberler.aid = iller.ilid)] 
		   WHERE 	[aid >= 5 and aid <= 20] 
		   ORDER BY [id DesC] 
		   GROUP BY	[aid] 
		   LIMIT 	[0,2]");
var_dump ($db->result);
var_dump ($db->sql);
/*
									- Screen Output -
﻿
array (size=2)
  0 => 
    array (size=6)
      'aid' => int 20
      'baslik' => string 'KingCert' in Karadağ ve Sırbistan Temsilciliği İçin Sözleşme İmzalandı' (length=79)
      'link' => string 'kingcert-in-karadag-ve-sirbistan-temsilciligi-icin-sozlesme-imzalandi' (length=69)
      'ilid' => int 20
      'Sehir' => string 'BURDUR' (length=6)
      'Plaka' => int 15
  1 => 
    array (size=6)
      'aid' => int 17
      'baslik' => string 'KingCert Kosova'da ISO 9001 Baş Denetçi Eğitimi Gerçekleştirdi' (length=67)
      'link' => string 'kingcert-kosova-da-iso-9001-bas-denetci-egitimi-gerceklestirdi' (length=62)
      'ilid' => int 17
      'Sehir' => string 'BİNGÖL' (length=8)
      'Plaka' => int 12
string 'SELECT haberler.aid, haberler.baslik, haberler.link, iller.ilid, iller.Sehir, iller.Plaka FROM haberler  inner JOIN iller  ON haberler.aid = iller.ilid  WHERE  aid >= 5 and aid <= 20 GROUP BY aid ORDER BY id DesC LIMIT  0,2' (length=223)	
*/		   

// Example 2
$db = new database();
$db->exec("SELECT 	[(iller:ilid, Sehir, Plaka)] 
		   WHERE 	[Sehir like '%SAK%']");
var_dump ($db->result);
var_dump ($db->sql);
/*
									- Screen Output -
﻿
array (size=3)
  'ilid' => int 67
  'Sehir' => string 'SAKARYA' (length=7)
  'Plaka' => int 54
string 'SELECT ilid,  Sehir,  Plaka FROM iller  WHERE  Sehir like '%SAK%'   ' (length=68)
*/	
?>