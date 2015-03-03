<?php
class database extends PDO
{
	#DEĞİŞKENLER B-----------------------------------------------#
	var $metot;
	var $tables;
	var $where;
	var $order;
	var $group;
	var $limit;
	var $join;
	var $sql;
	var $result;
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
		foreach ($result[0] AS $row){
		$row 	= trim($row);
		preg_match("/\[.*?\]/", $row, $re);
		$re 	= $re[0];
		$re 	= substr($re,1,((strlen($re))-2));
		$res[]  = array((strstr($row, " ", true)), $re);	
		}
		preg_match_all("/\(.*?\)/", $res[0][1], $result);
		unset($res[0][1]);
		
		foreach($result[0] AS $row)
		{
			array_push($res[0], substr($row,1,((strlen($row))-2)));
		}
		$res[0] = array_values($res[0]);
		$result = array_values($res);
		
		$this->metot = $result[0][0];
		for ($c=1;$c<=(count($result[0])-1);$c++)
		{
			$var = $result[0][$c];
			$this->tables[] = array((strstr($var, ":", true)));
			
			$var = strstr($var, ":");
			$var = substr($var, 1);
			if (strstr($var, "->")){
				$left  = strstr($var, "->", true);
				
				$left = explode(",", $left);
				foreach($left AS $row)
				{
					array_push($this->tables[$c-1], $row);	
				}
				
				$right = substr(strstr($var, "->"), 2);
				$this->join[] = (strstr($right, ",", true))." JOIN ".$this->tables[$c-1][0]." ".(substr(strstr($right, ","), 1));
				 
			}
			else{
				$var = explode(",", $var);
				foreach($var AS $row)
				{
					array_push($this->tables[$c-1], $row);	
				}
			}
			
		}
		
		for($c=1;$c<=(count($result)-1);$c++){
			$var = $result[$c][0];
			$var = strtolower($var);
			$this->$var = $result[$c][0]." ".$result[$c][1];
		}
		$this->sql();
	}//function p_explode
	
	public function sql()
	{
		var_dump($this->metot);
		var_dump($this->tables);
		var_dump($this->join);
		var_dump($this->where);
		var_dump($this->order);
		var_dump($this->group);
		var_dump($this->limit);	
		var_dump($this->sql);
	}
}


$db = new database();
$result = $db->exec("SELECT [(table1:id, ad, soyad), (table2:id,ad,soyad->inner, ON=table1.id = table2.id), (table3:yid,ad,soyad->left, ON=table1.id = table2.id)] 
		   WHERE [id = 5 and aid =4] 
		   ORDER BY [id DesC] 
		   GROUP BY[ad] 
		   LIMIT [0,7]");
//var_dump($result);		   


/*
Örnek
$result = $db->exec("SELECT [(table1:id, ad, soyad), (table2:id,ad,soyad->inner, ON=table1.id = table2.id)] 
		   WHERE [id = 5 and aid =4] 
		   ORDER BY [id DesC] 
		   GROUP BY[ad] 
		   LIMIT [0,7]");*/
?>