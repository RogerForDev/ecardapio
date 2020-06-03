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

  $('#colorPicker1').colorpicker({format: "hex"}).blur(function(){
    $(this).css('background-color',$(this).val());
  });
  $('#colorPicker2').colorpicker({format: "hex"}).blur(function(){
    $(this).css('background-color',$(this).val());
  });
  $('#colorPicker3').colorpicker({format: "hex"}).blur(function(){
    $(this).css('background-color',$(this).val());
  });
  $('#colorPicker4').colorpicker({format: "hex"}).blur(function(){
    $(this).css('background-color',$(this).val());
  }); 
  $('#font').fontselect().change(function(){
        
    // replace + signs with spaces for css
    var font = $(this).val().replace(/\+/g, ' ');
    
    // split font into family and weight
    font = font.split(':');
    
    // set family on paragraphs 
    $('#font-example').css('font-family', font[0]);
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