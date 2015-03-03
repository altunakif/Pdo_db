<?php
class database extends PDO
{
	#DEĞİŞKENLER B-----------------------------------------------#
	var $sql    = '';
	var $result = 'Null';
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
							   echo  "Error : ".$e->getMessage() ."<br/>"."File : ".$e->getFile() . "<br/>"."Line : ".$e->getLine() . "<br/>";
							   die;
							  }//catch S
	}//function __construct S
	#İLK ÇALIŞACAK S_______________________________________________#
	
	public function exec($str)
	{
		var_dump($str);
		
		$this->p_explode($str);
		return $this->result;
	}
	
	private function p_explode($str)
	{
		preg_match_all("/.*?\[.*?\]/", $str, $result);
		var_dump($result);
		
		foreach ($result[0] AS $row){
		$row 	= trim($row);
		preg_match("/\[.*?\]/", $row, $re);
		$re 	= $re[0];
		$re 	= substr($re,1,((strlen($re))-2));
		$re 	= '"akif", "osman"';
		$res[]  = array((strstr($row, " ", true)), "akif", "osman");	
		}
		
		$result = array_values($res);
		var_dump($result);
	}
	
}


$db = new database();
$result = $db->exec("SELECT [(table1:id, ad, soyad), (table2:id,ad,soyad->inner, ON=table1.id = table2.id)] 
		   WHERE [id = 5 and aid =4] 
		   ORDER BY [id DesC] 
		   GROUP BY[ad] 
		   LIMIT [0,7]");
var_dump($result);		   
?>