  <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Задачи</h1>
	
	<a class="btn btn-primary" href="/">На главную</a>
	    <table class="table table-striped">
	  <thead>
	  
		<tr>
		  <th scope="col">#</th>
		  <th scope="col" >ФИО</th>
		  <th scope="col">email</th>
		  
		  <th scope="col">Дата</th>
		  <th scope="col">Время</th>
		</tr>
	  </thead>
  <?php if($this->data):?>
	  <tbody>
	  <?php foreach($this->data as $value){?>
		<tr>
		  <th scope="row"><?php echo $value['id']; ?></th>
		  <td><?php h($value['FCS']); ?></td>
		  <td><?php h($value['email']); ?></td>
		  <td><?php h($value['form_date']); ?></td>
		  <td><?php h($value['form_time']); ?></td>
		</tr>
	  <?php }?>
	   
	  </tbody>
 
  <?php endif;?>
</table>
 <?php if($pagination->countPages > 1):?>
			<?=$pagination?>
	<?php endif;?>
  </div>
</div>
<!-- Button trigger modal -->







