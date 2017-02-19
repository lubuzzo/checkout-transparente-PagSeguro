<?php
function decodificar($id)
{
	if ($id == '1') {
		return json_encode(
			array(
				'id' => '1',
				'desc' => '4 apostilas em PDF: Linguagens e Códigos + Matemática + Ciências Humanas + Ciências da Natureza',
				'valor' => '49,90',
				'img' => 'https://www.infoenem.com.br/wp-content/uploads/2013/02/EcoversDigital300x300.png',
				)
			);
	
	} else if ($id == '2') {
		return json_encode(
			array(
				'id' => '2',
				'desc' => '4 apostilas impressas: Linguagens e Códigos + Matemática + Ciências Humanas + Ciências da Natureza',
				'valor' => '94,90',
				'img' => 'https://www.infoenem.com.br/wp-content/uploads/2013/02/Spirals300x300.png',
				)
			);

	} else if ($id == '3') {
		return json_encode(
			array(
				'id' => '3',
				'desc' => '4 apostilas em PDF + 4 apostilas impressas: Linguagens, Matemática, Ciências Humanas e da Natureza',
				'valor' => '99,90',
				'img' => '<img src="https://www.infoenem.com.br/wp-content/uploads/2013/02/EcoversDigital300x300.png" style="width: 170px;"><img src="https://www.infoenem.com.br/wp-content/uploads/2013/02/Mais(Transparente).png" style="margin-bottom: 65px;"><img src="https://www.infoenem.com.br/wp-content/uploads/2013/02/Spirals300x300.png" style="width: 170px;">',
				)
			);
	
	} else if ($id == '1406385621000') {
		return json_encode(
			array(
				'id' => '1406385621000',
				'desc' => 'Apostila Digital de Redação (PDF)',
				'valor' => '29,90',
				'img' => 'https://www.infoenem.com.br/wp-content/uploads/2014/08/arteredacao.png',
				)
			);
	
	} else if ($id == '0110') {
		return json_encode(
			array(
				'id' => '11',
				'desc' => 'Promoção! Apostila Digital de Redação (PDF)',
				'valor' => '19,90',
				'img' => 'https://www.infoenem.com.br/wp-content/uploads/2014/08/arteredacao.png',
				)
			);
	
	} else if ($id == '0007') {
		return json_encode(
			array(
				'id' => '0007',
				'desc' => 'Promoção! Kit 4 Apostilas (PDF)',
				'valor' => '29,80',
				'img' => 'https://www.infoenem.com.br/wp-content/uploads/2013/02/EcoversDigital300x300.png',
				)
			);

	} else if ($id == '11') {
		return json_encode(
			array(
				'id' => '11',
				'desc' => 'Promoção! Apostila Digital de Redação (PDF)',
				'valor' => '9,80',
				'img' => 'https://www.infoenem.com.br/wp-content/uploads/2014/08/arteredacao.png',
				)
			);
	}

}