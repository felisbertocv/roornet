<?php
include "config.php";
?>
<!DOCTYPE HTML>
<html land="pt-pt" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Projeto RoorNet</title>
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" />
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
<div class="container">
	<header class="masthead">
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<a class="brand" href="index.php">&nbsp;&nbsp;Projeto | Roor Net</a>
				<div class="container">
					<ul class="nav">
						<li class="active"><a href="index.php">Inicio</a></li>
						<li class="active"><a href="#">Maps</a></li>
					</ul>
				</div>
			</div>
		</nav>
		</br></br></br></br>
		<?php
		# CRIAR
		if(isset($_POST['enviar'])){
			$nomrua  = $_POST['nomrua'];
			$endereco  = $_POST['endereco'];
			$latitude  = $_POST['latitude'];
			$longitude = $_POST['longitude'];
			$altitude = $_POST['altitude'];
			$sql  = 'INSERT INTO Pontos (nomrua, endereco, latitude, longitude, altitude) ';
			$sql .= 'VALUES (:nomrua,:endereco,:latitude, :longitude, :altitude)';
			try {
				$create = $db->prepare($sql);
				$create->bindValue(':nomrua', $nomrua, PDO::PARAM_STR);
				$create->bindValue(':endereco', $endereco, PDO::PARAM_STR);
				$create->bindValue(':latitude', $latitude, PDO::PARAM_STR);
				$create->bindValue(':longitude', $longitude, PDO::PARAM_STR);
				$create->bindValue(':altitude', $altitude, PDO::PARAM_STR);
				if($create->execute()){
					echo "<div class='alert alert-success'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<strong>Inserido com sucesso!</strong>
					</div>";
				}
			} catch (PDOException $e) {
				echo "<div class='alert alert-error'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<strong>Erro ao inserir dados!</strong>" . $e->getMessage() . "
					</div>";
			}
		}
		#ATUALIZAR
		if(isset($_POST['atualizar'])){
			$cod_ponto = (int)$_GET['cod_ponto'];
			$nomrua = $_POST['nomrua'];
			$endereco = $_POST['endereco'];
			$latitude = $_POST['latitude'];
			$longitude = $_POST['longitude'];
			$altitude = $_POST['altitude'];
			$sqlUpdate = 'UPDATE pontos SET nomrua = ?, endereco = ?, latitude = ?,longitude = ?, altitude = ? WHERE cod_ponto = ?';
			$dados = array($nomrua,$endereco,$latitude,$longitude, $altitude, $cod_ponto);
			try {
				$update = $db->prepare($sqlUpdate);
				if($update->execute($dados)){
					echo "<div class='alert alert-success'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<strong>Alterado com sucesso!</strong>
					</div>";
				}
			}catch (PDOException $e) {
				echo "<div class='alert alert-error'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<strong>Erro ao Alterar dados!</strong>" . $e->getMessage() . "
					</div>";
			}
		}
		# ELIMINAR
		if(isset($_GET['action']) && $_GET['action'] == 'delete'){
			$cod_ponto = (int)$_GET['cod_ponto'];
			$sqlDelete = 'DELETE FROM pontos WHERE cod_ponto = :cod_ponto';
			try {
				$delete = $db->prepare($sqlDelete);
				$delete->bindValue(':cod_ponto', $cod_ponto, PDO::PARAM_INT);
				if($delete->execute()){
					echo "<div class='alert alert-success'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<strong>Eliminado com sucesso!</strong>
					</div>";
				}
			} catch (PDOException $e) {
				echo "<div class='alert alert-error'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<strong>Erro ao eliminar dados!</strong>" . $e->getMessage() . "
					</div>";
			}
		}?>
	</header>
	<article>
		<section class="jumbotron">
			<?php
			if(isset($_GET['action']) && $_GET['action'] == 'update'){
				$cod_ponto = (int)$_GET['cod_ponto'];
				$sqlSelect = 'SELECT * FROM pontos WHERE cod_ponto = :cod_ponto';
				try {
					$select = $db->prepare($sqlSelect);
					$select->bindValue(':cod_ponto', $cod_ponto, PDO::PARAM_INT);
					$select->execute();
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				$result = $select->fetch(PDO::FETCH_OBJ);
				?>
				<ul class="breadcrumb">
					<li><a href="index.php">Inicio <span class="divider"> /</span> </a></li>
					<li class="active">Alterar</li>
				</ul>
				<form method="post" action="">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-home"></i></span>
						<input type="text" name="nomrua" value="<?php echo $result->nomrua; ?>" placeholder="Nome da rua:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-map-marker"></i></span>
						<input type="text" name="endereco" value="<?php echo $result->endereco; ?>" placeholder="Endereço:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-map-marker"></i></span>
						<input type="text" name="latitude" value="<?php echo $result->latitude; ?>" placeholder="Latitude:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-map-marker"></i></span>
						<input type="text" name="longitude" value="<?php echo $result->longitude; ?>" placeholder="Longitude:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-map-marker"></i></span>
						<input type="text" name="altitude" value="<?php echo $result->altitude; ?>" placeholder="Altitude:" />
					</div>
					<br />
					<input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar dados">
					<input type="button" name="novo" class="btn btn-success" onClick="parent.location='index.php'" value="Novo">
				</form>
			<?php }else{ ?>
				<form method="post" action="">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-home"></i></span>
						<input type="text" name="nomrua" placeholder="Nome Rua:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-map-marker"></i></span>
						<input type="text" name="endereco" placeholder="Endereço:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-map-marker"></i></span>
						<input type="text" name="latitude" placeholder="Latitude:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-map-marker"></i></span>
						<input type="text" name="longitude" placeholder="Longitude:" />
					</div>
					<div class="input-prepend">
						<span class="add-on"><i class="icon-map-marker"></i></span>
						<input type="text" name="altitude" placeholder="Altitude:" />
					</div>
					<br />
					<input type="submit" name="enviar" class="btn btn-primary" value="Guardar">
				</form>
			<?php } ?>
			<table class="table table-hover">

				<thead>
				<tr>
					<th>#</th>
					<th>Nome Rua:</th>
					<th>Endereço:</th>
					<th>Latitude:</th>
					<th>Longitude:</th>
					<th>Altitude:</th>
					<th>Ações:</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$sqlRead = 'SELECT * FROM pontos';
				try {
					$read = $db->prepare($sqlRead);
					$read->execute();
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
				while( $rs = $read->fetch(PDO::FETCH_OBJ) ){
					?>
					<tr>
						<td><?php echo $rs->cod_ponto; ?></td>
						<td><?php echo $rs->nomrua; ?></td>
						<td><?php echo $rs->endereco; ?></td>
						<td><?php echo $rs->latitude; ?></td>
						<td><?php echo $rs->longitude; ?></td>
						<td><?php echo $rs->altitude; ?></td>
						<td>
							<a href="index.php?action=update&cod_ponto=<?php echo $rs->cod_ponto; ?>" class="btn"><i class="icon-pencil"></i></a>
							<a href="index.php?action=delete&cod_ponto=<?php echo $rs->cod_ponto; ?>" class="btn" onclick="return confirm('Deseja eliminar?');"><i class="icon-remove"></i></a>
						</td>
					</tr>
				<?php }	?>
				</tbody>
			</table>

		</section>
	</article>
</div>
<script src="js/jQuery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>