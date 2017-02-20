<?php

/*
Arquivo de configuração do ambiente
*/

$sandBox = 0;

if (!($sandBox)) {
	$emailPagseguro = "vendedor@loja.com";
	$tokenPagseguro = "123123123123121321";
	$urlNotificacao = "http://loja.exemplo.com/compra/notificacao.php";

	$scriptPagseguro = "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
	$urlPagseguro = "https://ws.pagseguro.uol.com.br/v2/";

} else {
	$emailPagseguro = "testador@loja.com";
	$tokenPagseguro = "123123123123";
	$urlNotificacao = "http://loja.exemplo.com/compra/notificacao.php";

	$scriptPagseguro = "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js";
	$urlPagseguro = "https://ws.sandbox.pagseguro.uol.com.br/v2/";
}
