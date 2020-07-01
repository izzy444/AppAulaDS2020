<?php

include('../../banco/conexao.php');

if(!$conexao){
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'OPS, não foi possível obter uma conexão com o banco de dados, tente mais tarde..'
    );
} else{

    $requestData = $_REQUEST;

    if(empty($requestData['nome']) || empty($requestData['ativo']) ){
        $dados = array(
            'tipo' => 'info',
            'mensagem' => 'Existe(m) campo(s) obrigatório(s) vazio(s).'
        );
    } else {

        //$requestData = array_map('utf8_decode', $requestData);

        $requestData['ativo'] = $requestData['ativo'] == "on" ? "S" : "N";

        //$requestData['dataagora'] = date('Y-d-m H:i:s', strtotime($requestData['dataagora']));

        $date = date_create_from_format('d/m/Y H:i:s', $requestData['dataagora']);
        $requestData['dataagora'] = date_format($date, 'Y-m-d H:i:s');

        $sqlComando = "INSERT INTO categorias (nome, ativo, datacriacao, datamodificacao)
         VALUES ('$requestData[nome]', '$requestData[ativo]', '$requestData[dataagora]', '$requestData[dataagora]')";

         $resultado = mysqli_query($conexao, $sqlComando);

         if($resultado){
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Categoria criada com sucesso.'
            );
         } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível criar a categoria.'.mysqli_error($conexao)
            );
         }
    }

    mysqli_close($conexao);
}

echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);