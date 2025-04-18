<?php
    require 'config/conexao.php';

    try {
        $conexao = Conexao::pegarConexao();
        echo "Conexão bem-sucedida!";
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
?>