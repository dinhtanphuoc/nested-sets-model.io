<?php
	require_once('./model.php');
	$model = new Nested();

	// INSERT
	if(isset($_POST['insert'])){
		if($_POST['radio'] == 'right'){
				$data = $_POST['Cate_name'];
				$parent = $_POST['parent'];
				$model->insertRight($data,$parent);
				header('Location: ./admin.php');
		}elseif($_POST['radio'] == 'left'){
				$data = $_POST['Cate_name'];
				$parent = $_POST['parent'];
				$model->insertLeft($data,$parent);
				header('Location: ./admin.php');
		}elseif($_POST['radio'] == 'after'){
				$data = $_POST['Cate_name'];
				$parent = $_POST['parent'];
				$brother = $_POST['brother'];
				$model->insertAfter($data,$parent,$brother);
				header('Location: ./admin.php');			
		}elseif($_POST['radio'] == 'before'){
				$data = $_POST['Cate_name'];
				$parent = $_POST['parent'];
				$brother = $_POST['brother'];
				$model->insertBefore($data,$parent,$brother);
				header('Location: ./admin.php');
		}else{
			echo "Option not null";
			exit;
		}
	}
	//DELETE
	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$model->removeBranch($id);
		header('Location: ./admin.php');
	}
	//MOVE
	if(isset($_POST['move'])){
		if($_POST['radio'] == 'moveright'){
				$data = $_POST['id'];
				$parent = $_POST['parent'];
				$model->moveRight($data,$parent);
				header('Location: ./admin.php');
		}elseif($_POST['radio'] == 'moveleft'){
				$data = $_POST['id'];
				$parent = $_POST['parent'];
				$model->moveLeft($data,$parent);
				header('Location: ./admin.php');
		}elseif($_POST['radio'] == 'moveafter'){
				$data = $_POST['id'];
				$parent = $_POST['parent'];
				$brother = $_POST['brother'];
				$model->moveAfter($data,$parent,$brother);
				header('Location: ./admin.php');			
		}elseif($_POST['radio'] == 'movebefore'){
				$data = $_POST['id'];
				$parent = $_POST['parent'];
				$brother = $_POST['brother'];
				$model->moveBefore($data,$parent,$brother);
				header('Location: ./admin.php');
		}else{
			echo "Option not null";
			exit;
		}
	}