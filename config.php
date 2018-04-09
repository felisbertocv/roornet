<?php
$conn = 'mysql:host=localhost;dbname=roornet';
try {
	$db = new PDO($conn, 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	if($e->getCode() == 1049){
		echo "Falha na Selecção da BD.";
	}else{
		echo $e->getMessage();
	}
}