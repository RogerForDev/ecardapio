

$(".layout").on("click", function(){
    let layout = $(this).data("layout");
    let url = $(this).data("url");
    $.ajax({
        url: url,
        type: "POST",
        data: {id_layout:layout},
        success:function(data){
            mensagem = JSON.parse(data);
            if(mensagem.type == "sucesso"){
                window.location.href = mensagem.path;
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: mensagem.message,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        }
    })
});