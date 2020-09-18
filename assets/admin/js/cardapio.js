$(document).ready(function(){
  $('#altera-telefone').mask('(99)0000-0000', {reverse: false});
  $('#altera-whats').mask('(99)99999-9999', {reverse: false});
  $('#preco-produto-cadastro').mask('999.999,99', {reverse: true});
  // $('#altera-horario').mask('00:00:00', {reverse: true});
  
});

$(".altera-imagem").on("click", function(){
  id = $(this).data("id");
  $(this).slideUp("2000", function(){
    $("#imagem-input"+id).slideDown();
  });
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip();

  $('.colorPicker1').colorpicker({format: "hex"}).blur(function(){
    $(this).css('background-color',$(this).val());
  });
  $('.colorPicker2').colorpicker({format: "hex"}).blur(function(){
    $(this).css('background-color',$(this).val());
  });
  $('.colorPicker3').colorpicker({format: "hex"}).blur(function(){
    $(this).css('background-color',$(this).val());
  });
  $('.colorPicker4').colorpicker({format: "hex"}).blur(function(){
    $(this).css('background-color',$(this).val());
  }); 
  $('.font-example').fontselect({placeholder: 'Selecione uma fonte',}).change(function(){
        
    // replace + signs with spaces for css
    var font = $(this).val().replace(/\+/g, ' ');
    
    // split font into family and weight
    font = font.split(':');
    
    // set family on paragraphs 
    $('.text-example').css('font-family', font[0]);
  }); 

})

function remove(url){
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não! deixa quieto',
        confirmButtonText: 'Sim, exclua isso!'
      }).then((result) => {
        if (result.value) {
          Swal.fire(
            'Excluido!',
            'Esse item foi excluido.',
            'success'
          );
          window.location.href = url; 
        }
      });
}
function setUpdate(url){
  $.get(url, function(data){
    if(data == 1){
      Swal.fire(
        'Salvo!',
        'Alterações salvas com sucesso.',
        'success'
      );
    }
  });
  setTimeout(function(){
    location.reload(true);
  }, 1500); 
}

$("#premium").on("change", function(){
  let opt = $(this).val();
  let url = $(this).data("url");
  if(opt == 0){
    var check = 2;
    $(this).val(1);
  }

  $.ajax({
    url: url,
    type: 'POST',            
    data: {check:check},
    success: function (data, status){
      mensagem = JSON.parse(data);
      if(mensagem.type == "sucesso"){
        $("#premium").attr('disabled','disabled');
        $("#free").attr("checked", false);
        $("#free").attr('disabled',false);
        $("#free").val("0");
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: mensagem.message,
          showConfirmButton: false,
          timer: 1500
        });
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: mensagem.message,
          showConfirmButton: false,
          timer: 1500
        })
      }
    }, error: function(e){
      console.log(e);
    }
  });
});

$("#free").on("change", function(){
  let opt = $(this).val();
  let url = $(this).data("url");
  if(opt == 0){
    var check = 1;
    $(this).val(1);
  }

  $.ajax({
    url: url,
    type: 'POST',            
    data: {check:check},
    success: function (data, status){
      mensagem = JSON.parse(data);
      if(mensagem.type == "sucesso"){
        $("#free").attr('disabled','disabled');
        $("#premium").attr("checked", false);
        $("#premium").attr('disabled',false);
        $("#premium").val("0");
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: "Você voltou ao plano gratuito com sucesso!",
          showConfirmButton: false,
          timer: 1500
        });
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: mensagem.message,
          showConfirmButton: false,
          timer: 1500
        })
      }
    }, error: function(e){
      console.log(e);
    }
  });
});

$(".assinar-plano").on("click", function(){
  let url = $(this).data("url");
  $.ajax({
    url: url,
    type: 'POST',            
    data: {check:2},
    success: function (data, status){
      mensagem = JSON.parse(data);
      if(mensagem.type == "sucesso"){
        $(".assinar-plano").attr('disabled','disabled');
        $(".assinar-plano").html("Você já é assinante");
        Swal.fire({
          icon: 'success',
          title: 'Sucesso',
          text: mensagem.message,
          showConfirmButton: false,
          timer: 3000
        });
      }else{
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: mensagem.message,
          showConfirmButton: false,
          timer: 1500
        })
      }
    }, error: function(e){
      console.log(e);
    }
  });
});

function downloadBanner(slug) {
    // document.querySelector('.no-print').remove();
    var el = document.getElementById('printThis');
    domtoimage.toJpeg(el, {
            quality: 0.95
        })
        .then(function(dataUrl) {
            var link = document.createElement('a');
            link.download = slug+'.jpeg';
            link.href = dataUrl;
            link.click();
        });
}