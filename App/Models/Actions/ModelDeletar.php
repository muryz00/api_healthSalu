<?php
include "Conexao.php";
include "Usuario.php";

class Delecao {

    public function deletar(Usuario $usuario) {
        $con = new Conexao();
        $bd = $con->pegarConexao();
        $bd->beginTransaction();

        try {
            // Deleta da tabela específica conforme o tipo
            if($usuario->getTipo() === "paciente") {
                $sqlPaciente = "DELETE FROM paciente WHERE cpf = ?";
                $stmPaciente = $bd->prepare($sqlPaciente);
                $stmPaciente->bindValue(1, $usuario->getId());
                $stmPaciente->execute();
            } else if($usuario->getTipo() === "medico") {
                $sqlMedico = "DELETE FROM medico WHERE cpf = ?";
                $stmMedico = $bd->prepare($sqlMedico);
                $stmMedico->bindValue(1, $usuario->getId());
                $stmMedico->execute();
            } else {
                throw new Exception("Tipo de usuário inválido.");
            }

            // Deleta na tabela `usuario`
            $sqlUsuario = "DELETE FROM usuario WHERE cpf = ?";
            $stmUsuario = $bd->prepare($sqlUsuario);
            $stmUsuario->bindValue(1, $usuario->getId());
            $stmUsuario->execute();

            $bd->commit();
            echo "Usuário deletado com sucesso!";
        } catch(Exception $e) {
            $bd->rollBack();
            echo "Erro ao deletar usuário: " . $e->getMessage();
        }
    }
}
?>
