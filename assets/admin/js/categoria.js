// $("#salvar-categoria").on("click", function(){
//     let form = new FormData();
//     var file_data = $('input[type="file"]')[0].files; // for multiple files
//     for(var i = 0;i<file_data.length;i++){
//         form.append("file_"+i, file_data[i]);
//     }
//     var other_data = $('#form-categoria').serializeArray();
//     $.each(other_data,function(key,input){
//         form.append(input.name,input.value);
//     });
//     url = $(this).data("url");
//     $.ajax({
//         method: "POST",
//         url : url,
//         data: form,
//         contentType: false,
//         processData: false,
//         success:function(result){
//             alert(result);
//             mensagem = JSON.parse(result);

//             if(mensagem.type == "sucesso"){
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Sucesso',
//                     text: mensagem.message,
//                     showConfirmButton: false,
//                     timer: 1500
//                 })
//             }else{
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Erro',
//                     text: mensagem.message,
//                     showConfirmButton: false,
//                     timer: 1500
//                 })
//             }
//         }   
//     });
// });

$(document).ready(function() {
    $('#imagem-categoria').filer({});       
});

$(document).on("submit", "#form-categoria", function(event)
{
    event.preventDefault();

    var url=$(this).attr("action");
    $.ajax({
        url: url,
        type: 'POST',            
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data, status){
            mensagem = JSON.parse(data);

            if(mensagem.type == "sucesso"){
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: mensagem.message,
                    showConfirmButton: false,
                    timer: 1500
                })
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
    });
});