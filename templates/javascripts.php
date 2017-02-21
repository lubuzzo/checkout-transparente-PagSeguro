<script type="text/javascript" src="<?php echo $scriptPagseguro; ?>"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script> //Máscaras dos inputs
  jQuery(function($){
  $("#creditCardHolderBirthDate").mask("99/99/9999");
  $("#senderCPF").mask("999.999.999-99");
  $("#creditCardHolderCPF").mask("999.999.999-99");
  $("#shippingAddressPostalCode").mask("99999-999");
  $("#billingAddressPostalCode").mask("99999-999");
  });

  $(document).ready(function() {
    $.ajax({
      type: 'GET',
      url: 'getSession.php',
      cache: false,
      success: function(data) {
        PagSeguroDirectPayment.setSessionId(data);
      }
    });
  });
</script>

<script>

$("input[name='changePaymentMethod']").on('click', function(e) {
    if (e.currentTarget.value == 'creditCard') {
      $('#boletoData').css('display', 'none');
      $('#creditCardData').css('display', 'block');
    } else if (e.currentTarget.value == 'boleto') {
      $('#creditCardData').css('display', 'none');
      $('#boletoData').css('display', 'block');
    }
});

$("input[name='holderType']").on('click', function(e) {
    if (e.currentTarget.value == 'sameHolder') {
      $('#dadosOtherPagador').css('display', 'none');
      ReInserir();
    } else if (e.currentTarget.value == 'otherHolder') {
      $('#dadosOtherPagador').css('display', 'block');
    }
});

$("input[type='text']").on('blur', function(e) {
    if ( ( $("#" + e.currentTarget.id).css('border') == '2px solid rgb(255, 0, 0)') || ($("#" + e.currentTarget.id).css('border') == '2px solid red' ) ) {
      $("#" + e.currentTarget.id).css('border', '1px solid #999');
    }
});

  function ReInserir() {
        $("#creditCardHolderName").val($("#senderName").val());
        $("#creditCardHolderCPF").val($("#senderCPF").val());
        $("#creditCardHolderAreaCode").val($("#senderAreaCode").val());
        $("#creditCardHolderPhone").val($("#senderPhone").val());
        $("#billingAddressPostalCode").val($("#shippingAddressPostalCode").val());
        $("#billingAddressStreet").val($("#shippingAddressStreet").val());
        $("#billingAddressNumber").val($("#shippingAddressNumber").val());
        $("#billingAddressComplement").val($("#shippingAddressComplement").val());
        $("#billingAddressDistrict").val($("#shippingAddressDistrict").val());
        $("#billingAddressCity").val($("#shippingAddressCity").val());
        $("#billingAddressState").val($("#shippingAddressState").val());
        $("#billingAddressCountry").val("BRA");
  }
</script>

<script>

  function parcelasDisponiveis() {
    PagSeguroDirectPayment.getInstallments({
      amount: (($("#totalValue").html()).replace(",", ".")),
      brand: $("#creditCardBrand").val(),
      maxInstallmentNoInterest: 2,

      success: function(response) {
        //console.log(response.installments);
        $("#installmentsWrapper").css('display', "block");


        var installments = response.installments[$("#creditCardBrand").val()];

        var options = '';
        for (var i in installments) {

          var optionItem     = installments[i];
          var optionQuantity = optionItem.quantity;
          var optionAmount   = optionItem.installmentAmount;
          var optionLabel    = (optionQuantity + " x R$ " + (optionAmount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,').replace(".", ',')));

          options += ('<option value="' + optionItem.quantity + '" valorparcela="' + optionAmount +'">'+ optionLabel +'</option>');

        };

        $("#installmentQuantity").html(options);

      },

      error: function(response) {
        //console.log(response);
      },

      complete: function(response) {
      }
    });
  }

  $("#installmentQuantity").change(function() {
    var option = $(this).find("option:selected");
    if (option.length) {
      $("#installmentValue").val( option.attr("valorparcela") );
    }
  });

  function brandCard() {

    PagSeguroDirectPayment.getBrand({
      cardBin: $("#cardNumber").val(),
      success: function(response) {
        $("#creditCardBrand").val(response.brand.name);
        $("#cardNumber").css('border', '1px solid #999');

        if (response.brand.expirable) {
          $("#expiraCartao").css('display', 'block');
        } else {
          $("#expiraCartao").css('display', 'none');
        }
        if (response.brand.cvvSize > 0) {
          $("#cvvCartao").css('display', 'block');
        } else {
          $("#cvvCartao").css('display', 'none');
        }

        $("#bandeiraCartao").attr('src', 'https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/' + response.brand.name + '.png');


        parcelasDisponiveis();

      },

      error: function(response) {
        $("#cardNumber").css('border', '2px solid red');
        $("#cardNumber").focus();
      },

      complete: function(response) {

      }

    });

  }

  function showModal() {
      $("#modal-title").html("Aguarde");
      $("#modal-body").html("");
      $("#aguarde").modal("show");
  }

  function pagarBoleto(senderHash) {
    showModal();
    $.ajax({
      type: 'POST',
      url: 'pagamentoBoleto.php',
      cache: false,
      data: {
        id: <?php echo $_GET['id']; ?>,
        email: $("#senderEmail").val(),
        nome: $("#senderName").val(),
        cpf: $("#senderCPF").val(),
        ddd: $("#senderAreaCode").val(),
        telefone: $("#senderPhone").val(),
        cep: $("#shippingAddressPostalCode").val(),
        endereco: $("#shippingAddressStreet").val(),
        numero: $("#shippingAddressNumber").val(),
        complemento: $("#shippingAddressComplement").val(),
        bairro: $("#shippingAddressDistrict").val(),
        cidade: $("#shippingAddressCity").val(),
        estado: $("#shippingAddressState").val(),
        pais: "BRA",
        senderHash: senderHash,
      },
      success: function(data) {

        if (!(data.paymentLink)) {
          //alert(data);
          $("#modal-title").html("<font color='red'>Erro</font>");

          $("#modal-body").html("");
          //console.log(data.error);
          $.each(data.error, function (index, value) {
            if (value.code) {
              //console.log("6 " + value.code);
              tratarError(value.code);
            } else {
              //console.log("7 " + data.error);
              tratarError(data.error.code);
            }

          });
        } else {
          window.location = data.paymentLink;
          setTimeout(function () {
            $("#modal-body").html("");
            $("#modal-title").html("<font color='green'>Sucesso!</font>")

            $("#modal-body").html("Caso você não seja redirecionado para o seu boleto, clique no botão abaixo.<br /><br /><a href='" + data.paymentLink + "'><center><img src='images/boleto.png' /><br /><br /><button class='btn-success btn-block btn-lg'>Ir para o meu boleto</button></center></a>");
          }, 3500);
        }

      }
    });

  }

    function pagarCartao(senderHash) {
      showModal();

      PagSeguroDirectPayment.createCardToken({

        cardNumber: $("#cardNumber").val(),
        brand: $("#creditCardBrand").val(),
        cvv: $("#cardCvv").val(),
        expirationMonth: $("#cardExpirationMonth").val(),
        expirationYear: $("#cardExpirationYear").val(),

        success: function (response) {
          $("#creditCardToken").val(response.card.token);
        },
        error: function (response) {
          if (response.error) {
            $("#modal-title").html("<font color='red'>Erro</font>");

            $("#modal-body").html("");
            //console.log("4" + response);
            $.each(response.errors, function (index, value) {
              //console.log(value);
              tratarError(value);
            });
          }
        },
        complete: function (response) {

        }

      });


      $.ajax({
        type: 'POST',
        url: 'pagamentoCartao.php',
        cache: false,
        data: {
          id: <?php echo $_GET['id']; ?>,
          email: $("#senderEmail").val(),
          nome: $("#senderName").val(),
          cpf: $("#senderCPF").val(),
          ddd: $("#senderAreaCode").val(),
          telefone: $("#senderPhone").val(),
          cep: $("#shippingAddressPostalCode").val(),
          endereco: $("#shippingAddressStreet").val(),
          numero: $("#shippingAddressNumber").val(),
          complemento: $("#shippingAddressComplement").val(),
          bairro: $("#shippingAddressDistrict").val(),
          cidade: $("#shippingAddressCity").val(),
          estado: $("#shippingAddressState").val(),
          pais: "BRA",
          senderHash: senderHash,

          enderecoPagamento: $("#billingAddressStreet").val(),
          numeroPagamento: $("#billingAddressNumber").val(),
          complementoPagamento: $("#billingAddressComplement").val(),
          bairroPagamento: $("#billingAddressDistrict").val(),
          cepPagamento: $("#billingAddressPostalCode").val(),
          cidadePagamento: $("#billingAddressCity").val(),
          estadoPagamento: $("#billingAddressState").val(),
          cardToken: $("#creditCardToken").val(),
          cardNome: $("#creditCardHolderName").val(),
          cardCPF: $("#creditCardHolderCPF").val(),
          cardNasc: $("#creditCardHolderBirthDate").val(),
          cardFoneArea: $("#creditCardHolderAreaCode").val(),
          cardFoneNum: $("#creditCardHolderPhone").val(),

          numParcelas: $("#installmentQuantity").val(),
          valorParcelas: $("#installmentValue").val(),

        },
        success: function(data) {
          //console.log(data);
          if (data.error) {
            if (data.error.code == "53037") {
              $("#creditCardPaymentButton").click();
            } else {
              $("#modal-title").html("<font color='red'>Erro</font>");

              $("#modal-body").html("");
              $.each(data.error, function (index, value) {
                if (value.code) {
                  tratarError(value.code);

                } else {
                  tratarError(data.error.code)
                }
              })
              //console.log("2 " + data);
            }
          } else {


            $.ajax({
              type: 'POST',
              url: 'getStatus.php',
              cache: false,
              data: {
                id: data.code,
              },
              success: function(status) {

                if (status == "7") {
                  //alert(data);
                  $("#modal-title").html("<font color='red'>Erro</font>");

                  $("#modal-body").html("Erro ao processar o seu pagamento.<br/> Não se preocupe pois esse valor <b>não será debitado de sua conta ou não constará em sua fatura</b><br /><br />Verifique se você possui limite suficiente para efetuar a transação e/ou tente um cartão diferente");

                } else {
                  window.location = "http://download.infoenem.com.br/pagamento-efetuado/";
                  setTimeout(function () {
                    $("#modal-body").html("");
                    $("#modal-title").html("<font color='green'>Sucesso!</font>")

                    $("#modal-body").html("Caso você não seja redirecionado para a nossa página de instruções, clique no botão abaixo.<br /><br /><a href='http://download.infoenem.com.br/pagamento-efetuado/'><center><button class='btn-success btn-block btn-lg'>Ir para a página de instruções</button></center></a>");
                  }, 1500);
                }

              }
            });


            //console.log("1 " + data);
          }

          }

      });

    }

function tratarError(id) {
  if (id.charAt(0) == '2') id = id.substr(1);
  if (id == "53020" || id == '53021') {
    $("#modal-body").append("<p>Verifique telefone inserido</p>");
    $("#senderPhone").css('border', '2px solid red');

  } else if (id == "53010" || id == '53011' || id == '53012') {
    $("#modal-body").append("<p>Verifique o e-mail inserido</p>");
    $("#senderEmail").css('border', '2px solid red');

  } else if (id == "53017") {
    $("#modal-body").append("<p>Verifique o CPF inserido</p>");
    $("#senderCPF").css('border', '2px solid red');

  } else if (id == "53018" || id == "53019") {
    $("#modal-body").append("<p>Verifique o DDD inserido</p>");
    $("#senderAreaCode").css('border', '2px solid red');

  } else if (id == "53013" || id == '53014' || id == '53015') {
    $("#modal-body").append("<p>Verifique o nome inserido</p>");
    $("#senderName").css('border', '2px solid red');

  } else if (id == "53029" || id == '53030') {
    $("#modal-body").append("<p>Verifique o bairro inserido</p>");
    $("#shippingAddressDistrict").css('border', '2px solid red');

  } else if (id == "53022" || id == '53023') {
    $("#modal-body").append("<p>Verifique o CEP inserido</p>");
    $("#shippingAddressPostalCode").css('border', '2px solid red');

  } else if (id == "53024" || id == '53025') {
    $("#modal-body").append("<p>Verifique a rua inserido</p>");
    $("#shippingAddressStreet").css('border', '2px solid red');

  } else if (id == "53026" || id == '53027') {
    $("#modal-body").append("<p>Verifique o número inserido</p>");
    $("#shippingAddressNumber").css('border', '2px solid red');

  } else if (id == "53033" || id == '53034') {
    $("#modal-body").append("<p>Verifique o estado inserido</p>");
    $("#shippingAddressState").css('border', '2px solid red');

  } else if (id == "53031" || id == '53032') {
    $("#modal-body").append("<p>Verifique a cidade informada</p>");
    $("#shippingAddressCity").css('border', '2px solid red');

  } else if (id == '10001') {
    $("#modal-body").append("<p>Verifique o número do cartão inserido</p>");
    $("#cardNumber").css('border', '2px solid red');

  } else if (id == '10002' || id == '30405') {
    $("#modal-body").append("<p>Verifique a data de validade do cartão inserido</p>");
    $("#cardExpirationMonth").css('border', '2px solid red');
    $("#cardExpirationYear").css('border', '2px solid red');

  } else if (id == '10004') {
    $("#modal-body").append("<p>É obrigatorio informar o código de segurança, que se encontra no verso, do cartão</p>");
    $("#cardCvv").css('border', '2px solid red');

  } else if (id == '10006' || id == '10003' || id == '53037') {
    $("#modal-body").append("<p>Verifique o código de segurança do cartão informado</p>");
    $("#cardCvv").css('border', '2px solid red');

  } else if (id == '30404') {
    $("#modal-body").append("<p>Ocorreu um erro. Atualize a página e tente novamente!</p>");

  } else if (id == '53047') {
    $("#modal-body").append("<p>Verifique a data de nascimento do titular do cartão informada</p>");
    $("#creditCardHolderBirthDate").css('border', '2px solid red');

  } else if (id == '53053' || id == '53054') {
    $("#modal-body").append("<p>Verifique o CEP inserido</p>");
    $("#billingAddressPostalCode").css('border', '2px solid red');

  } else if (id == '53055' || id == '53056') {
    $("#modal-body").append("<p>Verifique a rua inserido</p>");
    $("#billingAddressStreet").css('border', '2px solid red');

  } else if (id == '53042' || id == '53043' || id == '53044') {
    $("#modal-body").append("<p>Verifique o nome inserido</p>");
    $("#creditCardHolderName").css('border', '2px solid red');

  } else if (id == '53057' || id == '53058') {
    $("#modal-body").append("<p>Verifique o número inserido</p>");
    $("#billingAddressNumber").css('border', '2px solid red');

  } else if (id == '53062' || id == '53063') {
    $("#modal-body").append("<p>Verifique a cidade informada</p>");
    $("#billingAddressCity").css('border', '2px solid red');

  } else if (id == '53045' || id == '53046') {
    $("#modal-body").append("<p>Verifique o CPF inserido</p>");
    $("#creditCardHolderCPF").css('border', '2px solid red');

  } else if (id == '53060' || id == '53061') {
    $("#modal-body").append("<p>Verifique o bairro inserido</p>");
    $("#billingAddressDistrict").css('border', '2px solid red');

  } else if (id == '53064' || id == '53065') {
    $("#modal-body").append("<p>Verifique o estado inserido</p>");
    $("#billingAddressState").css('border', '2px solid red');

  } else if (id == '53051' || id == '53052') {
    $("#modal-body").append("<p>Verifique telefone inserido</p>");
    $("#billingAddressState").css('border', '2px solid red');

  } else if (id == '53049' || id == '53050') {
    $("#modal-body").append("<p>Verifique o código de área informado</p>");
    $("#creditCardHolderAreaCode").css('border', '2px solid red');

  } else if (id == '53122') {
    $("#modal-body").append("<p>Enquanto na sandbox do PagSeguro, o e-mail deve ter o domínio '@sandbox.pagseguro.com.br' (ex.: comprador@sandbox.pagseguro.com.br)</p>");

  }

  // else {
  //   $("#modal-body").append("<p>"+ id + "</p>");
  // }
}

</script>
