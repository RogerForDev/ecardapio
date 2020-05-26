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
          )
          window.location.href = url; 
        }
      });
}

function showSaveButton(n){
    $('#input-name'+n).removeAttr('readonly');
    $('#btnSaveCat'+n).removeClass('d-none');    
}

function hideSaveButton(n){
    $('#input-name'+n).attr('readonly', 'true');
    $('#btnSaveCat'+n).addClass('d-none');
}