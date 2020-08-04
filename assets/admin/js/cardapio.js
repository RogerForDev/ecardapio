$(document).ready(function(){
  $('#altera-telefone').mask('0000-0000', {reverse: true});
  $('#altera-whats').mask('99999-9999', {reverse: true});
  $('#altera-horario').mask('00:00:00', {reverse: true});
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
  $('.font-example').fontselect().change(function(){
        
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
function submitBackground(url){
  var data = 
  $.post(url+'/admin/cardapio/background', data, function(res){
    if(res == 1){
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