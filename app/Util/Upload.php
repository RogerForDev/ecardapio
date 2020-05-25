<?php
namespace App\Util;

use App\Controllers\Controller;

class Upload extends Controller{

    public function __construct()
    {
        
    }

    public function upload($arquivo){

        $dataDia = date("d");
        $dataMes = date("m");
        $dataAno = date("Y");
        $caminho = DIR_PATH.'/uploads/images/' . $dataAno . '/' . $dataMes . '/'  . $dataDia . '/' . time().uniqid() . '/';
        if (!file_exists($caminho) && !is_dir($caminho)) {
            mkdir($caminho, 0777, true);
        }
    
        $_UP['pasta'] = $caminho;
        // Tamanho máximo do arquivo (em Bytes)
        $_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
        // Array com as extensões permitidas
        $_UP['extensoes'] = array('jpg', 'pdf', 'jpeg');
        // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
        $_UP['renomeia'] = true;
        // Array com os tipos de erros de upload do PHP
        $_UP['erros'][0] = 'Não houve erro';
        $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
        $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
        $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
        $_UP['erros'][4] = 'Não foi feito o upload do arquivo';
    
        if ($_FILES[$arquivo]['name'] !== '' && $_FILES[$arquivo]['size'] > 0) {
            

            // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
            if ($_FILES[$arquivo]['error'] != 0) {
                return "Ocorreu um erro com o carregamento do arquivo ".$_FILES[$arquivo]['name'];
                exit();
            }

            // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
            // Faz a verificação da extensão do arquivo
            $extensao1 = explode('.', $_FILES[$arquivo]['name']);
            $extensao2 = end($extensao1);
            $extensao = strtolower($extensao2);
            if (array_search($extensao, $_UP['extensoes']) === false) {
                return "Arquivo ".$_FILES[$arquivo]['name']." está fora do padrão! Por favor, envie o documento na extensão solicitada: PDF ou JPG";
                exit();
            }
            // Faz a verificação do tamanho do arquivo
            if ($_UP['tamanho'] < $_FILES[$arquivo]['size']) {
            return "Arquivo ".$_FILES[$arquivo]['name']." enviado é muito grande, envie arquivos de até 2Mb.";
                exit();
            }
            // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
            // Primeiro verifica se deve trocar o nome do arquivo
            if ($_UP['renomeia']) {
                // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
                $nome_final = 'arquivo'.md5(time()) . '.' . $extensao;
            } else {
                // Mantém o nome original do arquivo
                $nome_final = $_FILES[$arquivo]['name'];
            }

            // Depois verifica se é possível mover o arquivo para a pasta escolhida
            if (move_uploaded_file($_FILES[$arquivo]['tmp_name'], $_UP['pasta'] . $nome_final)) {
                // Upload efetuado com sucesso, variavel recebe o caminho do arquivo
                $docLiq = $_UP['pasta'] . $nome_final;
                return $docLiq;
            } else {
                return "Não foi possível realizar o upload do arquivo ".$_FILES[$arquivo]['name']." por erro interno.";
                exit();
            }
        }
    }

    
}
?>