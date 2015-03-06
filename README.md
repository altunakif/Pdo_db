Insert, Update, Delete, Select yapabileceğiniz PDO kullanarak yapılmış bir veritabanı sınıfıdır. Geliştirilmesi devam
etmektedir.

# Connection #
$db = new database('localhost', 'testdb', 'testuser', 'password');

# Insert #
- usage     : $db->exec("insert [(table:columns=value, columns=value)]");
- Example 1 : $db->exec("insert [(email:adsoyad='akif', email= 'Başlık')]");
- Example 2 : $db->exec("insert [(email:adsoyad='akif', email= 'Başlık'), (haberler:baslik='baslik', icerik= 'icerik')]");

# Update #
- usage     : $db->exec("update [(table:columns=value, columns=value)] Where [(columns = value)]");
- Example 1 : $db->exec("update [(email:adsoyad='Akif ALTUN', mesaj= 'Deneme Başlık')]
			                  Where [(id = 50)]");
- Example 2 : $db->exec("UPDATE [(email:adsoyad='akif', mesaj= 'Başlık'), (haberler:baslik='baslik', icerik= 'icerik')]
			                  Where [(id = 50)]");
			
# Delete #
- usage     : $db->exec("delete [(table:columns=value)]");
- Example 1 : $db->exec("DELETE [(email:id = 36)]");
- Example 2 : $db->exec("delete [(email:adsoyad='Sibel Pamuk'), (haberler:baslik='baslik')]");

# Select #
- usage     : $db->exec("select [(table:columns, columns, ..), (table:columns, columns, ..->(inner, left, right), ON table.value = table.value)..] Where [(columns = value)] ORDER BY [value DesC,ASC]  GROUP BY [value] LIMIT [int,int]");
- Example 1 : $db->exec("SELECT 	[(haberler:aid, baslik, link), (iller:ilid, Sehir, Plaka->inner, ON haberler.aid = iller.ilid)] 
		                     WHERE 	[aid >= 5 and aid <= 20] 
		                   ORDER BY [id DesC] 
		                  GROUP BY	[aid] 
		                     LIMIT 	[0,2]");
		                     
- Example 2 : $db->exec("SELECT 	[(iller:ilid, Sehir, Plaka)] 
		                    WHERE 	[Sehir like '%SAK%']");		                     
