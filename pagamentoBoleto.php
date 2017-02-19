<?php
include 'env.php';

include 'templates/dadosProduto.php';
$dadosProduto = json_decode(decodificar($_POST['id']));

$_POST['cpf'] = str_replace(".", "", $_POST['cpf']);
$_POST['cpf'] = str_replace("-", "", $_POST['cpf']);

$valor = $dadosProduto->valor;
$valor = str_replace(",", ".", $valor);

include 'gerarXml.php';
$xml = gerarXmlBoleto($_POST['id'], $dadosProduto->desc, $valor, $_POST['nome'], $_POST['cpf'], $_POST['ddd'], $_POST['telefone'], $_POST['email'], $_POST['senderHash'], $_POST['endereco'], $_POST['numero'], $_POST['complemento'], $_POST['bairro'], $_POST['cep'], $_POST['cidade'], $_POST['estado']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlPagseguro . "transactions/?email=" . $emailPagseguro . "&token=" . $tokenPagseguro);
curl_setopt($ch, CURLOPT_POST, true );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml; charset=ISO-8859-1'));

$data = curl_exec($ch);
$dataXML = simplexml_load_string($data);

if (empty($dataXML->paymentLink)) {
	header('Content-Type: application/json; charset=UTF-8');
	$errosOcorridos = array('erro' => '1');
	echo json_encode($dataXML);
} else {
	header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($dataXML);
}
curl_close($ch);