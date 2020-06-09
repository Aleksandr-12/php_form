<?php
require_once "./functions.php";
require_once "./Pagination.php";
require_once "./Model/model_class.php";
require_once "./Model/CSV_class.php";
require_once "Controller.php";


class PageController extends Controller{
	
	
	public $db = '';
	public $id = '';
	public $data = '';
	
	public function __construct($pageName = '', $data = '') {
		session_start();
		$this->data = $data;
		$this->db = model_class::getDB();
		$this->createPage($pageName);
		
	}

	public function createPage($pageName=''){
		
		
		switch($pageName){
			
			case 'admin':
				$this->PageAdmin();
				break;
			case  'auth':
				$this->PageAuth();
				break;
			case  'outer':
				$this->PageExit();
				break;
			
			default:
				$this->PageHome();
				break;
		}
	
	}
	
	public function PageHome(){
		$this->title = 'Home';
				
		
		$page = isset($_GET['page']) ? (int)$_GET['page'] :1;
		$perpage = 3;
		$pagination = new Pagination($page, $perpage,$total);
		$start = $pagination->getStart();
		$data = $this->db->select('php_form', "$orderBy LIMIT $start, $perpage");
		$this->showPage($data, $pagination);
	}
	
	public function PageAdmin(){
		
		if($_SESSION['name']){
			$this->title= 'Admin';
			$this->view = 'admin';
			$data = $this->db->select('php_form');
			
			$csv = new CSV_class("./form.csv");
			$csv->setCSV($data);
			
			$this->db->PHPe($data);
			
			$page = isset($_GET['page']) ? (int)$_GET['page'] :1;
			$perpage = 3;
			$total = $this->db->CountData();
			$pagination = new Pagination($page, $perpage,$total);
			$start = $pagination->getStart();
			
			$data = $this->db->select('php_form', "LIMIT $start, $perpage");
			$this->showPage($data,$pagination);
			
		}else{
			redirect('/auth');
		}
	}
	
	public function PageAuth(){
		
		/*if($_SESSION['name']){
			redirect('/');
			
		}elseif($this->data['name'] and $this->data['password']){
			if($this->db->AuthUser($this->data['name'],$this->data['password'])){
				redirect();
			}else{
				redirect('/auth');
			}
		}else{
			$_SESSION['error'] = 'Поля логин\пароль обязательные для заполнения';
			$this->title= 'Авторизоваться';
			$this->view = 'auth';
			$this->showPage();
		}*/
		if($_SESSION['name']){
			redirect('/');
			
		}
		if($_POST['auth']){
			if($this->db->AuthUser($_POST['name'],$_POST['password'])){
				redirect();
			}else{
				redirect('/auth');
			}
		}else{
			$this->title= 'Авторизоваться';
			$this->view = 'auth';
			$this->showPage();
		}
			
	}
	public function PageExit(){
		unset($_SESSION['name']);
		$_SESSION['exit'] = 'Вы успешно вышли!';
		redirect();
	}
}
?>