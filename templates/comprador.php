<div class="col-md-4">

  <div class="groupData" id="buyerData">

    <div>
      <h1>Dados do comprador</h1>
      <div style="margin-top:-20px; text-align:right;">
        <font color="red">* Campos de preenchimento obrigatório</font>
      </div>
    </div>

    <div class="field" style="margin-top:-5px;">
      <label for="senderEmail">E-mail <font color="red">*</font></label>
      <input type="text" name="senderEmail" id="senderEmail" required="required" />
    </div>

    <div class="field" style="margin-top:-5px">
      <label for="senderName">Nome completo <font color="red">*</font></label>
      <input type="text" name="senderName" id="senderName" required="required"/>
    </div>

    <div class="field" style="margin-top:-5px">
      <label for="senderCPF">CPF (somente números) <font color="red">*</font></label>
      <input type="text" name="senderCPF" id="senderCPF" maxlength="14" required="required"/>
    </div>

    <div class="field" style="margin-top:-5px">
      <label for="senderAreaCode">Telefone <font color="red">*</font></label>
      <input type="text" name="senderAreaCode" id="senderAreaCode" class="areaCode" maxlength="2" required="required"/>
      <input type="text" name="senderPhone" id="senderPhone" class="phone" maxlength="9" required="required" />
    </div>

    <h2>Endereço Residencial</h2>

    <div class="field" style="margin-top: -10px;">
      <label for="shippingAddressPostalCode">CEP (somente números) <font color="red">*</font></label>
      <input type="text" name="shippingAddressPostalCode" id="shippingAddressPostalCode" maxlength="9" required="required"/>
    </div>

    <div style="margin-top:-10px;">

      <div class="field">
        <label for="shippingAddressStreet">Endereço <font color="red">*</font></label>
        <input type="text" name="shippingAddressStreet" id="shippingAddressStreet" required="required"/>
      </div>

      <div class="field">
        <label for="shippingAddressNumber">Número <font color="red">*</font></label>
        <input type="text" name="shippingAddressNumber" id="shippingAddressNumber" size="5" required="required"/>  
      </div>
    
    </div>

    <div class="field" style="margin-top: 0px;">
      <label for="shippingAddressComplement">Complemento</label>
      <input type="text" name="shippingAddressComplement" id="shippingAddressComplement" />
    </div>

    <div class="field" style="margin-top:-5px;">
      <label for="shippingAddressDistrict">Bairro <font color="red">*</font></label>
      <input type="text" name="shippingAddressDistrict" id="shippingAddressDistrict" required="required"/>
    </div>

    <div class="field" style="margin-top:-5px;">
      <label for="shippingAddressCity">Cidade <font color="red">*</font></label>
      <input type="text" name="shippingAddressCity" id="shippingAddressCity" required="required"/>
    </div>

    <div class="field" style="margin-top:-5px;">
      <label for="shippingAddressState">Estado <font color="red">*</font></label>
      <input type="text" name="shippingAddressState" id="shippingAddressState" class="addressState" maxlength="2" style="text-transform: uppercase;" onBlur="this.value=this.value.toUpperCase()" required="required"/>
    </div>
    
    <div class="field" style="display: none">
      <label for="shippingAddressCountry">País</label>
      <input type="text" name="shippingAddressCountry" id="shippingAddressCountry" value="Brasil" readonly="readonly" />
    </div>

    <p style="float: left"><b>Esta compra está sendo feita no Brasil</b> <img src="images/Brasil.png" alt="Bandeira do Brasil" title="Bandeira do Brasil" style="width: 64px;"/> </p>

    <p style="clear: both"></p>

  </div>
</div>