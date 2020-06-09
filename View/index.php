  <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Задачи</h1>
	<?php if(!$_SESSION['name']):?>
	<a href="/auth" class="btn mt-2 mb-2 btn-primary" >
		Авторизоваться
	</a>
		<?php else:?>
			<a class="btn btn-primary"  href="/admin">Админ панель</a>
			<a class="btn btn-danger"  href="/outer">Выйти</a>
			
		<?php endif;?>
		<?php if($_SESSION['success']):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo $_SESSION['success'];?>
			</div>
		<?php  endif;?>
		<?php unset($_SESSION['success']);?>
		
		<?php if($_SESSION['exit']):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo $_SESSION['exit'];?>
			</div>
		<?php  endif;?>
		<?php unset($_SESSION['exit']);?>
		<?php if($_SESSION['error']):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo $_SESSION['error'];?>
			</div>
		<?php  endif;?>
		<?php unset($_SESSION['error']);?>
		
		
		<?php if(getFlash('php_form')):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo getFlash('php_form');?>
			</div>
		<?php  endif;?>
		<?php delFlash('php_form');?>
		

	
	  <form action="/manager.php"  method="POST">
      <div class="modal-body">
		  <div class="form-group">
			<label for="exampleInputName">ФИО</label>
			<input name="FCS" type="text" class="form-control" aria-describedby="exampleInputName" placeholder="Имя" required>
			
		 </div>
		  <div class="form-group">
			<label for="emailForm">E-mail</label>
			<input id="emailForm" name="email" type="email" class="form-control" placeholder="email" required>
		  </div>
		   <div class="form-group">
			<label for="dateForm">Желаемя дата</label>
			<input id="dateForm" name="form_date" type="date" class="form-control" placeholder="Желаемя дата" required>
		  </div>
		   <div class="form-group">
			<label for="timeForm">Желаемя время</label>
			<input id="timeForm" name="form_time" type="time" class="form-control" placeholder="Желаемя время" required>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Отправить</button>
      </div>
	  </form>
    
	</div>
</div>




