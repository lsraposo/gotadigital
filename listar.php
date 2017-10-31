<?php

require_once 'DB.php';

	$sql = "SELECT idEndereco, enderecoNumero, enderecoCadastro, enderecoCidade  FROM tbendereco WHERE tbcadastro_idCadastro = ?";
	$stmt = DB::prepare($sql);
	$stmt->bindParam(1, $_POST["idEnd"], PDO::PARAM_INT);
	$stmt->execute();

	$result_json = array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$result_json[] = $row;

	}


	echo json_encode($result_json);


?>