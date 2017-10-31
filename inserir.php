
//TRABALHO DE CONCLUSÃO DE CURSO - GOTA DIGITAL

//Autores:
//
//Mailson Marques
//APOIO - Dheyson
//Luciano

<?php

require_once 'DB.php';

	$sql = "INSERT INTO tbcadastro(nomeCadastro, cpfCadastro, emailCadastro, senhaCadastro) VALUES (?,?,?,?)";
	$stmt = DB::prepare($sql);
	$stmt->bindParam(1, $_POST["nome"], PDO::PARAM_STR);
	$stmt->bindParam(2, $_POST["cpf"], PDO::PARAM_STR);
	$stmt->bindParam(3, $_POST["emailCadastro"], PDO::PARAM_STR);
	$stmt->bindParam(4, $_POST["senhaCadastro"], PDO::PARAM_STR);
	$obj = $stmt->execute();

	$sql = "SELECT * FROM tbcadastro WHERE idCadastro = (SELECT max(idCadastro) FROM tbcadastro)";
	$stmt = DB::prepare($sql);
	$stmt->execute();

	$result_json = array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$result_json[] = $row;

	}

	if ($obj == true)
		$retorno = array("retorno" => "YES" ) + $result_json[0];

	else
		$retorno = array("retorno" => "NO");

	echo json_encode($retorno);


?>