
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
            console.log(data);

            if(mensagem.type == "sucesso"){
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: mensagem.message,
                    showConfirmButton: false,
                    timer: 1500
                });

                let html = "<div class='row'><div id='"+mensagem.nome+"' class='col-xl-12'><input data-id='"+mensagem.id+"' type='text' class='bg-cat-title py-3 h5 w-100 border-0 text-center nome-categoria' readonly='true' title='Clique para editar o nome da categoria' data-toggle='tooltip' data-placement='top' value="+mensagem.nome+">-</div></div>";
                $("#conteudo").append(html);

                let linha = $("<br><div class='row'></div>");
                let card = $("<div class='col-xl-3 pb-3'><div class='card text-left'><div class='card-body py-4'><a href='' class='novo-produto-generico' data-toggle='modal' data-target='#modalNewProductGeneric' data-id='"+mensagem.id+"' data-categoria='"+mensagem.nome+"'><h3 class='card-title text-center text-dark'><i class='fa fa-plus fa-2x'></i><br>Adicionar produto</h3></a></div></div></div>");
                linha.append(card);

                $("#conteudo").append(linha);

                $("#modalCategoria").modal("hide");
                $("#card-sem-categoria").hide();
            }else{
                console.log(data);
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: mensagem.message,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        },
        error: function(e){
            console.log(e.responseText);
        }
    });
});

$(document).on("click", ".novo-produto-generico", function(){
    let categoria = $(this).data("categoria");
    let idCategoria = $(this).data("id");
    $("#id-categoria-generico").val(idCategoria);
    $("#titulo-produto").html("Novo produto da categoria "+categoria);
});

$(document).on("focusin", ".nome-categoria", function(){
    $(this).removeAttr('readonly');
});

$(document).on("focusout", ".nome-categoria", function(){
    $(this).attr('readonly');
    let nome = $(this).val();
    let idCategoria = $(this).data("id");
    url = $("#path").val();
    url += "admin/categorias/update";

    $.ajax({
        url: url,
        type: 'POST',            
        data: {id : idCategoria, nome : nome},
        success: function (data, status){
             console.log(data);
            mensagem = JSON.parse(data);
            if(mensagem.type == "sucesso"){
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: mensagem.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }else{
                console.log(data);
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

$(document).on("mouseenter", ".nome-categoria, .deletar-categoria", function(){
    // $('#input-name'+n).removeAttr('readonly');
    $(".deletar-categoria").removeClass('d-none');    
});

$(document).on("mouseleave", ".nome-categoria", function(){
    // $('#input-name'+n).attr('readonly', 'true');
    $(".deletar-categoria").addClass('d-none');
});

