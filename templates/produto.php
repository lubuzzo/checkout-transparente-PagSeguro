<div class="col-md-4">
  <div class="groupData" id="cartData">

    <div id="carWrapper">
    <?php include 'dadosProduto.php';
      $dadosProduto = json_decode(decodificar($_GET['id'])); ?>
      <table id="cartTable" style="margin: 0 0 -1em 0; ">
        <thead>
          <tr>
            <th class="tableProduto">Descrição</th>
            <th class="tableProduto">Valor</th>
          </tr>
        </thead>
        <tbody>
          <td><?php echo $dadosProduto->desc; ?></th>
          <td>R$ <?php echo $dadosProduto->valor; ?></th>
        </tbody>
      </table>
    </div>

    <div style="text-align: right"><h3 id="cartTotal"> Valor Total: R$ <span id="totalValue"><?php echo $dadosProduto->valor; ?></span> </h3></div>

  </div>

</div>

<div class="hidden-xs hidden-sm .visible-md-block .visible-lg-block" style="float: left; margin-top: 220px; margin-left: -390px">
  <?php if($dadosProduto->id != 3) { ?><img src="<?php echo $dadosProduto->img; ?>" width='300px' /> <?php } else if ($dadosProduto->id == 3) echo $dadosProduto->img; ?>
</div>