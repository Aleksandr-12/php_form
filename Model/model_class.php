<?php 
require_once "./Config.php";
require_once "./vendor/vlucas/valitron/src/Valitron/Validator.php";
require_once "./PHPExcel/Classes/PHPExcel.php";

use Valitron\Validator;

class model_class{
	
	private $config;
	private $mysqli;
	private static $db = null;
	public $errors = [];
		
	public $rules = [
        'required' => [
            ['FCS'],
            ['email'],
           
        ],
		'email' => [
			['email'],
		],	
    ];
	
	public function __construct() {
		$this->config = new Config();
		$this->mysqli = new mysqli($this->config->db_host, $this->config->db_user, $this->config->db_password, $this->config->db_name);
		$this->mysqli->query("SET NAMES 'utf8'");
	}
	
	public static function getDB() {
		if (self::$db == null) self::$db = new model_class();
		return self::$db;
	}
	public function PHPe($res){
		
		$objPHPExcel = new PHPExcel();
		
		/*$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
					->setLastModifiedBy("Maarten Balliauw")
					->setTitle("Office 2007 XLSX Test Document")
					->setSubject("Office 2007 XLSX Test Document")
					->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
					->setKeywords("office 2007 openxml php")
					->setCategory("Test result file");*/
		$i = null;
		
		foreach($res as $val)
		{
			$i++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i", $val[FCS]);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$i", $val[email]);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$i", $val[form_date]);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$i", $val[form_time]);
		}
	 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		if(file_exists('./phpform.xlsx')){
			unlink('./phpform.xlsx');
		}
		
		$objWriter->save('phpform.xlsx');
	}

	public function select($table_name, $param = '', $array = true){
		$query = "SELECT * FROM `".$table_name."`$param ";
		$result = $this->mysqli->query($query);
		if (!$result) return 'error';
		
		if($array){
				$data = array();
				while (($row = $result->fetch_assoc()) != false) {
				$data[] = $row;
			}
		}else{
			$data = $result->fetch_assoc();
		}
		
		return $data;
	}
	
	public function save($data, $table_name){
		$fields = array('FCS','email','form_date','form_time');
		$query = "INSERT INTO ".$table_name." (";
	
		foreach ($fields as $field => $value){
			$query .= "`$value`,";
		}
		$query = substr($query, 0, -1);
		$query .= ") VALUES (";
		foreach ($data as $field => $value){
			$val = $this->secureAcces($value);
			$query .= "'$val',";
		} 
		
		$query = substr($query, 0, -1);
		
		$query .= ")";
		$this->mysqli->query($query);
		
	}
	
		
	public function CountData(){
		$query = "SELECT COUNT(*) FROM php_form";
		$result = $this->mysqli->query($query);
		$result = $result->fetch_assoc();
		return $result['COUNT(*)'];
		
	}
	
	public function AuthUser($name,$pass){
		$name = $this->secureAcces($name);
		$pass = $this->secureAcces($pass);
		if($pass == '' or $name == ''){
			if($pass == '' AND $name != ''){
				$_SESSION['error'] = 'Поле пароль обязательно для заполнения';
				return false;
			}
			if($pass == '' AND $name == ''){
				$_SESSION['error'] = 'Поле имя\логин обязательные для заполнения';
				return false;
			}
			if($name == '' AND $pass != ''){
				$_SESSION['error'] = 'Поле имя обязательно для заполнения';
				return false;
			}
		}
		$pass = md5($pass);
		$result = $this->select('user',"WHERE name='$name' AND password='$pass'");
		if($result){
			$_SESSION['name'] = 'admin';
			$_SESSION['success'] = 'Вы успешно авторизированы';
			return true;
			
		}else{
			$_SESSION['error'] = 'Не верно введен логин\пароль';
			return false;
		}
	}
	
	public function secureAcces($var){
		$var = htmlspecialchars($var,ENT_QUOTES);
		$var = trim($var);
		$var = addslashes($var); 
		return $var;
	}
	public function getErrors(){
		$errors = '<ul>';
			foreach($this->errors as $error){
				foreach($error as $item){
					$errors .= "<li>$item</li>";
				}
			}
		$errors .= '</ul>';
		$_SESSION['error'] = $errors;
	}
	
	 public function validate($data){
		Validator::lang('ru');
        $v = new Validator($data);
		
		$v->rules($this->rules);
		
        if($v->validate()){
            return true;
        }
        $this->errors = $v->errors();
        return false;
    }
	
}


?>