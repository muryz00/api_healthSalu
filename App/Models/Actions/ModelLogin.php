<?php
include "Conexao.php";

class Login {

    public function login($email, $senha) {
        $con = new Conexao();
        $bd = $con->pegarConexao();

        // Atenção: o ideal é armazenar senhas criptografadas
        $sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
        $stm = $bd->prepare($sql);
        $stm->bindValue(1, $email);
        $stm->bindValue(2, $senha);
        $stm->execute();

        if ($stm->rowCount() > 0) {
            $usuario = $stm->fetch(\PDO::FETCH_ASSOC);
            return json_encode($usuario);
        } else {
            return json_encode(["mensagem" => "Usuário não encontrado ou senha incorreta."]);
        }
    }
}
?>
