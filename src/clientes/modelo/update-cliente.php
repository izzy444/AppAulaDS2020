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

        $id = isset($requestData['idcliente']) ? $requestData['idcategoria'] : '';

        $requestData['ativo'] = $requestData['ativo'] == "on" ? "S" : "N";

        //$requestData['dataagora'] = date('Y-m-d H:i:s', strtotime($requestData['dataagora']));

        $requestData['dataagora'] = date_format(new DateTime($requestData['dataagora']), 'Y-m-d H:i:s');

        $sqlComando = "UPDATE clientes SET nome = '$requestData[nome]', ativo = '$requestData[ativo]', datamodificacao = '$requestData[dataagora]'  WHERE idcliente = $id ";

        $resultado = mysqli_query($conexao, $sqlComando);

         if($resultado){
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Cliente alterado com sucesso.'
            );
         } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível alterar o cliente.'.mysqli_error($conexao)
            );
         }
    }

    mysqli_close($conexao);
}

echo json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);