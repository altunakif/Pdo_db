<?php
class database extends PDO
{
	#DEĞİŞKENLER B-----------------------------------------------#
	var 	$metot;
	var 	$tables;
	var 	$where;
	var 	$order;
	var 	$group;
	var 	$limit;
	var 	$join;
	var 	$sql;
	public  $result;
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
			if (($var == "order") OR ($var == "group")) $by = "BY";
			else $by = "";
			$this->$var = $result[$c][0]." $by ".$result[$c][1];
		}
		$this->make_sql();
	}//function p_explode
	
	public function make_sql()
	{
		if ((count($this->tables))== 1)
		{
			for ($c=1;$c<=(count($this->tables[0])-1);$c++){
			$col .= $this->tables[0][$c].", ";
			}
			
			$col = trim($col);
			$col = substr("$col", 0, -1);
			$table = $this->tables[0][0]; 
		}
		else{
			foreach ($this->tables AS $row){
				$table = $row[0];
				for($c=1; $c<=(count($row)-1);$c++){
					$var = trim($row[$c]);
					$col .= "{$table}.{$var}, ";
				}
			}
			$col   = trim($col);
			$col   = substr($col, 0, -1);
			$table = $this->tables[0][0]; 
		}
		
		if (!is_null($this->join)){
			foreach($this->join AS $row) {$join .=" $row ";}
		}
		else $join = "";
		
		if (!is_null($this->where)) $where = $this->where;
		else $where ="";
		
		if (!is_null($this->order)) $order = $this->order;
		else $order ="";
		
		if (!is_null($this->group)) $group = $this->group;
		else $group ="";
		
		if (!is_null($this->limit)) $limit = $this->limit;
		else $limit ="";
		
		$this->sql = $this->metot." ". $col." FROM ".$table." ".$join." ".$where." ".$group." ".$order." ".$limit;
		echo $this->sql;
		$this->run();
	}//function sql
	
	public function run()
	{
		$metot = $this->metot;
		$metot = strtolower($metot);
		if ($metot == "select"){
			$query = PDO::query($this->sql);
			$query = $query->fetchAll(PDO::FETCH_ASSOC);
			$this->result = $query;
		}
	}
}


$db = new database();
$result =  $db->exec("SELECT [(email:id, type, adsoyad), (blog:id,category,title->inner, ON email.id = blog.id)]");
var_dump ($db->result);		   
echo $db->sql;		   


/*
Örnek
$result = $db->exec("SELECT [(table1:id, ad, soyad), (table2:id,ad,soyad->inner, ON table1.id = table2.id)] 
		   WHERE [id = 5 and aid =4] 
		   ORDER BY [id DesC] 
		   GROUP BY[ad] 
		   LIMIT [0,7]");*/
?>