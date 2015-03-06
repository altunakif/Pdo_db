Insert, Update, Delete, Select yapabileceğiniz PDO kullanarak yapılmış bir veritabanı sınıfıdır. Geliştirilmesi devam
etmektedir.

# Connection #
$db = new database('localhost', 'testdb', 'testuser', 'password');

# Insert #
-Example 1 : $db->exec("insert [(email:adsoyad='akif', email= 'Başlık')]");
-Example 2 : $db->exec("insert [(email:adsoyad='akif', email= 'Başlık'), (haberler:baslik='baslik', icerik= 'icerik')]");

# Update #
Example 1 : $db->exec("uPdaTe [(email:adsoyad='Akif ALTUN', mesaj= 'Deneme Başlık')]
			                  Where [(id = 50)]");
- Çoklu Update - 
Example 2 : $db->exec("uPdaTe [(email:adsoyad='akif', mesaj= 'Başlık'), (haberler:baslik='baslik', icerik= 'icerik')]
			                  Where [(id = 50)]");
			
# Delete #
Example 1 : $db->exec("DEleTe [(email:id = 36)]");
- Çoklu Delete - 
Example 2 : $db->exec("DEleTe [(email:adsoyad='Sibel Pamuk'), (haberler:baslik='baslik')]");

# Select #
Example 1 : $db->exec("SELECT 	[(haberler:aid, baslik, link), (iller:ilid, Sehir, Plaka->inner, ON haberler.aid = iller.ilid)] 
		                     WHERE 	[aid >= 5 and aid <= 20] 
		                   ORDER BY [id DesC] 
		                  GROUP BY	[aid] 
		                     LIMIT 	[0,2]");
		                     
Example 2 : $db->exec("SELECT 	[(iller:ilid, Sehir, Plaka)] 
		                    WHERE 	[Sehir like '%SAK%']");		                     
