
//TRABALHO DE CONCLUSÃO DE CURSO - GOTA DIGITAL

//Autores:
//
//Mailson Marques
//APOIO - Dheyson
//Luciano

<?php

require_once 'DB.php';


	$sql = "INSERT INTO tbendereco(enderecoCadastro, enderecoNumero, enderecoBairro, tbCadastro_idCadastro, enderecoTipo, enderecoCidade) VALUES (?,?,?,?,?,?)";
	$stmt = DB::prepare($sql);
	$stmt->bindParam(1, $_POST["enderecoCadastro"], PDO::PARAM_STR);
	$stmt->bindParam(2, $_POST["enderecoNumero"], PDO::PARAM_STR);
	$stmt->bindParam(3, $_POST["enderecoBairro"], PDO::PARAM_STR);
	$stmt->bindParam(4, $_POST["idEnd"], PDO::PARAM_INT);
	$stmt->bindParam(5, $_POST["enderecoTipo"], PDO::PARAM_STR);
	$stmt->bindParam(6, $_POST["enderecoCidade"], PDO::PARAM_STR);

	if($stmt->execute())
		$retorno = array("retorno" => "YES");

	else
		$retorno = array("retorno" => "NO");

	echo json_encode($retorno);

?>