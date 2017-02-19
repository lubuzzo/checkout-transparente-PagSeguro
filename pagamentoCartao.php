<?php
include "env.php";

include 'templates/dadosProduto.php';
$dadosProduto = json_decode(decodificar($_POST['id']));

$_POST['cpf'] = str_replace(".", "", $_POST['cpf']);
$_POST['cpf'] = str_replace("-", "", $_POST['cpf']);

$_POST['cardCPF'] = str_replace(".", "", $_POST['cardCPF']);
$_POST['cardCPF'] = str_replace("-", "", $_POST['cardCPF']);

$valor = $dadosProduto->valor;
$valor = str_replace(",", ".", $valor);
$valor = number_format($valor, 2, '.', '');

if (!(isset($_POST['valorParcelas'])) || empty($_POST['valorParcelas'])) {
	$_POST['valorParcelas'] = $valor;
}

if (!(isset($_POST['numParcelas'])) || empty($_POST['numParcelas'])) {
	$_POST['numParcelas'] = 1;
}


$_POST['valorParcelas'] = (number_format($_POST['valorParcelas'], 2));
$_POST['valorParcelas'] = str_replace(",", ".", $_POST['valorParcelas']);

$_POST['numParcelas'] = intval($_POST['numParcelas']);


include 'gerarXml.php';

$xml = gerarXmlCartao($_POST['id'], $dadosProduto->desc, $valor, $_POST['nome'], $_POST['cpf'], $_POST['ddd'], $_POST['telefone'], $_POST['email'], $_POST['senderHash'], $_POST['endereco'], $_POST['numero'], $_POST['complemento'], $_POST['bairro'], $_POST['cep'], $_POST['cidade'], $_POST['estado'], $_POST['enderecoPagamento'], $_POST['numeroPagamento'], $_POST['complementoPagamento'], $_POST['bairroPagamento'], $_POST['cepPagamento'], $_POST['cidadePagamento'], $_POST['estadoPagamento'], $_POST['cardToken'], $_POST['cardNome'], $_POST['cardCPF'], $_POST['cardNasc'], $_POST['cardFoneArea'], $_POST['cardFoneNum'], $_POST['numParcelas'], $_POST['valorParcelas']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlPagseguro . "transactions/?email=" . $emailPagseguro . "&token=" . $tokenPagseguro);
curl_setopt($ch, CURLOPT_POST, true );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml; charset=ISO-8859-1'));

$data = curl_exec($ch);
$dataXML = simplexml_load_string($data);

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($dataXML);
 	
curl_close($ch);