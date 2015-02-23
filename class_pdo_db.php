<?php
/*
- Class database
- @author Akif ALTUN
- email altun_akif@hotmail.com
- date 23.02.2015
*/
class database extends PDO
{
	#DEĞİŞKENLER B-----------------------------------------------#
	/*Parametrelerde ekleme çıkarma yapıldığında sorguların hazırlandığı fonksiyonlarda ilgili değişiklik yapılmalıdır*/
	var $sql = '';
	var $c   = ''; // Columns  Parametreleri
	var $t   = ''; // Table    Parametreleri
	var $w   = ''; // Where    Parametreleri
	var $j   = ''; // Join 	   Parametreleri
	var $o   = ''; // Order By Parametreleri
	var $g   = ''; // Group By Parametreleri
	var $co  = ''; // Count    Parametreleri
	#DEĞİŞKENLER S_______________________________________________#
	
	#İLK ÇALIŞACAK B-----------------------------------------------#
	/*Kurucu fonksiyondur. Db bağlantı yapar*/
	public function __construct($host = 'localhost', $dbname = 'k_dbo', $username = 'root', $password = '')
	{
		$dsn	 = "mysql:dbname={$dbname}; host={$host}";
		$options = array(PDO::ATTR_CASE 				=> PDO::CASE_NATURAL,
        				 PDO::ATTR_ERRMODE 				=> PDO::ERRMODE_SILENT,
        				 PDO::ATTR_ORACLE_NULLS 		=> PDO::NULL_NATURAL,
        				 PDO::ATTR_STRINGIFY_FETCHES	=> false,
        				 PDO::ATTR_EMULATE_PREPARES 	=> false,
						 PDO::ATTR_DEFAULT_FETCH_MODE 	=> PDO::FETCH_ASSOC,
						 PDO::MYSQL_ATTR_INIT_COMMAND 	=> "SET NAMES utf8");
						 
		try {
			parent::__construct($dsn, $username, $password, $options);
			} //try S
		catch(PDOException $e){
							   echo "Veri Tabanı Bağlantı HATASI!!! : " . $e->getMessage() . "<br/>";
							   die;
							  }//catch S
	}//function __construct S
	#İLK ÇALIŞACAK S_______________________________________________#
	
	#EXPLODE FONKSİYON B-----------------------------------------------#
	/*Kullanıcıdan gelen parametreleri kullanılabilir hale getirir*/
	private function p_explode($param){
		$param = explode(",",$param);
		foreach($param as $row)
		{
			$row = explode(":", $row);
			$row[0] = trim($row[0]);
			$row[1] = trim($row[1]);
			try
			{
				if (@is_null($this->{"$row[0]"})) throw new Exception("{{$row[0]}} geçersiz parametri!");
				$this->{"$row[0]"}.=" {$row[1]},";
			}
			catch (Exception $e) 
			{
				 echo "Hata!: " . $e->getMessage() . "<br/>";
			}
		}
		/*Parametrelerin en sonundaki gereksiz virgülü siler*/
		if (!empty($this->c)){$this->c = trim($this->c); $this->c = substr($this->c, 0, -1);}
		if (!empty($this->t)){$this->t = trim($this->t); $this->t = substr($this->t, 0, -1);}
		if (!empty($this->w)){$this->w = trim($this->w); $this->w = substr($this->w, 0, -1);}
		if (!empty($this->j)){$this->j = trim($this->j); $this->j = substr($this->j, 0, -1);}
		if (!empty($this->o)){$this->o = trim($this->o); $this->o = substr($this->o, 0, -1);}
		if (!empty($this->g)){$this->g = trim($this->g); $this->g = substr($this->g, 0, -1);}
		if (!empty($this->co)){$this->co = trim($this->co); $this->co = substr($this->co, 0, -1);}
	}
	#EXPLODE FONKSİYON S_______________________________________________#
	
	#SELECT İŞLEMİ B-----------------------------------------------#
	/*Select işlemi için sql sorgu hazırlar*/
	public function select($param){
		$this->p_explode($param);
		if (empty($this->c)) $this->c = "*";
		if (empty($this->w)) $this->w = "";
		else $this->w = "WHERE {$this->w}";
		$this->sql = "SELECT {$this->c} FROM {$this->t} {$this->w}";
		$this->execute('select', $this->sql);
	} //function select() S
	#SELECT İŞLEMİ S_______________________________________________#
	
	#EXECUTE İŞLEMİ B-----------------------------------------------#
	public function execute($func, $sql)
	{
		echo $sql."<br>";
		$query = $this->prepare($sql);
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		var_dump($result);
		return "akif";
	}
	#EXECUTE İŞLEMİ S_______________________________________________#
}	

$db = new database();
$qr = $db->select("c:id, c:type,c:email, t:email");
var_dump($qr);
?>