<?php
	require_once('./model.php');
	$nested = new Nested(); 
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>ADMIN</title>
		<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">		
	</head>
	<body>
		<div class="container">
		<div class="row">
			<div class="col-md-12">
				<legend><a href="./index.php">-->>Back<<--</a></legend>
			</div>
		</div>
			<div class="row">
				<div class="col-md-4">
				<legend>INSERT </legend>
					<form action="./controller.php" method="POST">
				    	<div class="form-group">
				      		<label>Name</label>
				      		<input type="text" class="form-control" name="Cate_name" placeholder="Category_name">
				      		<label>Parent</label>
				      		<select class="form-control" name="parent" >
				      		<option selected="selected">-------------------------</option>
				      		<?php 
				      			$rows = $nested->selectAll();
				      			while($row = $rows->fetch_assoc()){
				      		?>
				      			<option value="<?php echo $row['id'];?>"><?php echo '[ Name: '.$row['Category_name'].' ]--[ ID ('.$row['id'].') ]--[ Parent ('. $row['Category_parent_id'].') ]';?></option>
				      		<?php
				      			}
				      		?>
				      		</select>
				      		<label>Brother</label>
				      		<select class="form-control" name="brother" >
				      		<option selected="selected">-------------------------</option>
				      		<?php 
				      			$rows = $nested->selectAll();
				      			while($row = $rows->fetch_assoc()){
				      		?>
				      			<option value="<?php echo $row['id'];?>"><?php echo '[ Name: '.$row['Category_name'].' ]--[ ID ('.$row['id'].') ]--[ Parent ('. $row['Category_parent_id'].') ]';?></option>
				      		<?php
				      			}
				      		?>
				      		</select>
				      		<div class="radio">
							    <label><input type="radio" name="radio" value="right"> Insert Right</label>
							</div>
							<div class="radio">
							    <label><input type="radio" name="radio" value="left"> Insert Left</label>
							</div>
							<div class="radio">
							    <label><input type="radio" name="radio" value="after"> Insert After</label>
							</div>	
							<div class="radio">
							    <label><input type="radio" name="radio" value="before"> Insert Before</label>
							</div>
				    	</div>
				    	<button type="submit" class="btn btn-primary" name="insert">INSERT</button>
					</form>
				</div>
				<div class="col-md-4">
				<legend>DELETE </legend>
					<form action="./controller.php" method="POST">
				    	<div class="form-group">
				      		<label>Parent</label>
				      		<select class="form-control" name="id" >
				      		<option selected="selected">-------------------------</option>
				      		<?php 
				      			$rows = $nested->selectAll();
				      			while($row = $rows->fetch_assoc()){
				      		?>
				      			<option value="<?php echo $row['id'];?>"><?php echo '[ Name: '.$row['Category_name'].' ]-[ ID ('.$row['id'].') ]-[ Parent ('. $row['Category_parent_id'].') ]';?></option>
				      		<?php
				      			}
				      		?>
				      		</select>
				    	</div>
				    	<button type="submit" class="btn btn-primary" name="delete">DELETE</button>
					</form>
				</div>
				<div class="col-md-4">
				<legend>MOVE </legend>
					<form action="./controller.php" method="POST">
				    	<div class="form-group">
				      		<label>ID</label>
				      		<select class="form-control" name="id" >
				      		<option selected="selected">-------------------------</option>
				      		<?php 
				      			$rows = $nested->selectAll();
				      			while($row = $rows->fetch_assoc()){
				      		?>
				      			<option value="<?php echo $row['id'];?>"><?php echo '[ Name: '.$row['Category_name'].' ]--[ ID ('.$row['id'].') ]';?></option>
				      		<?php
				      			}
				      		?>
				      		</select>
				      		<label>Parent</label>
				      		<select class="form-control" name="parent" >
				      		<option selected="selected">-------------------------</option>
				      		<?php 
				      			$rows = $nested->selectAll();
				      			while($row = $rows->fetch_assoc()){
				      		?>
				      			<option value="<?php echo $row['id'];?>"><?php echo '[ Name: '.$row['Category_name'].' ]--[ ID ('.$row['id'].') ]--[ Parent ('. $row['Category_parent_id'].') ]';?></option>
				      		<?php
				      			}
				      		?>
				      		</select>
				      		<label>Brother</label>
				      		<select class="form-control" name="brother" >
				      		<option selected="selected">-------------------------</option>
				      		<?php 
				      			$rows = $nested->selectAll();
				      			while($row = $rows->fetch_assoc()){
				      		?>
				      			<option value="<?php echo $row['id'];?>"><?php echo '[ Name: '.$row['Category_name'].' ]--[ ID ('.$row['id'].') ]--[ Parent ('. $row['Category_parent_id'].') ]';?></option>
				      		<?php
				      			}
				      		?>
				      		</select>
				      		<div class="radio">
							    <label><input type="radio" name="radio" value="moveright"> Move Right</label>
							</div>
							<div class="radio">
							    <label><input type="radio" name="radio" value="moveleft"> Move Left</label>
							</div>
							<div class="radio">
							    <label><input type="radio" name="radio" value="moveafter"> Move After</label>
							</div>
							<div class="radio">
							    <label><input type="radio" name="radio" value="movebefore"> Move Before</label>
							</div>
				    	</div>
				    	<button type="submit" class="btn btn-primary" name="move">MOVE</button>
					</form>
				</div>
			</div>
			<table class="table table-bordered">
				<thead>
				    <tr>
				    	<th>ID</th>
				    	<th>Name</th>
				    	<th>Parent</th>
				    	<th>Left</th>
				    	<th>Right</th>
				    	<th>Date</th>	
				   	</tr>
				</thead>
				<?php
					$row = $nested->selectAll();
					while ($rows = $row->fetch_assoc()) {
				?>
				<tbody>
			      	<tr>
			        	<td><?php echo $rows['id'];?></td>
			        	<td><?php echo $rows['Category_name'];?></td>
			        	<td><?php echo $rows['Category_parent_id'];?></td>
			        	<td><?php echo $rows['Category_left'];?></td>
			        	<td><?php echo $rows['Category_right'];?></td>
			        	<td><?php echo $rows['Category_date'];?></td>
			      	</tr>
			    </tbody>
			    <?php
			    	}
			    ?>
			</table>
		</div>	
	</body>
</html>