<?php
include "Conexao.php";
include "Usuario.php";
include "Paciente.php";
include "Medico.php";

class Atualizacao {

    public function atualizar(Usuario $usuario, $dadosAdicionais) {
        $con = new Conexao();
        $bd = $con->pegarConexao();
        $bd->beginTransaction();

        try {
            // Atualiza na tabela `usuario`
            $sqlUsuario = "UPDATE usuario SET nome = ?, email = ?, senha = ?, tipo = ? WHERE cpf = ?";
            $stmUsuario = $bd->prepare($sqlUsuario);
            $stmUsuario->bindValue(1, $usuario->getNome());
            $stmUsuario->bindValue(2, $usuario->getEmail());
            $stmUsuario->bindValue(3, $usuario->getSenha());
            $stmUsuario->bindValue(4, $usuario->getTipo());
            $stmUsuario->bindValue(5, $usuario->getId());
            $stmUsuario->execute();

            // Atualiza na tabela específica conforme o tipo
            if($usuario->getTipo() === "paciente") {
                if(!$dadosAdicionais instanceof Paciente) {
                    throw new Exception("Dados adicionais incompatíveis.");
                }
                $sqlPaciente = "UPDATE paciente SET cpf = ?, data_nasc = ?, telefone = ? WHERE cpf = ?";
                $stmPaciente = $bd->prepare($sqlPaciente);
                $stmPaciente->bindValue(1, $dadosAdicionais->getCpf());
                $stmPaciente->bindValue(2, $dadosAdicionais->getDataNasc());
                $stmPaciente->bindValue(3, $dadosAdicionais->getTelefone());
                $stmPaciente->bindValue(4, $usuario->getId());
                $stmPaciente->execute();
            } else if($usuario->getTipo() === "medico") {
                if(!$dadosAdicionais instanceof Medico) {
                    throw new Exception("Dados adicionais incompatíveis.");
                }
                $sqlMedico = "UPDATE medico SET cpf = ?, crm = ?, especialidade = ?, telefone = ? WHERE cpf = ?";
                $stmMedico = $bd->prepare($sqlMedico);
                $stmMedico->bindValue(1, $dadosAdicionais->getCpf());
                $stmMedico->bindValue(2, $dadosAdicionais->getCrm());
                $stmMedico->bindValue(3, $dadosAdicionais->getEspecialidade());
                $stmMedico->bindValue(4, $dadosAdicionais->getTelefone());
                $stmMedico->bindValue(5, $usuario->getId());
                $stmMedico->execute();
            } else {
                throw new Exception("Tipo de usuário inválido.");
            }

            $bd->commit();
            echo "Atualização realizada com sucesso!";
        } catch(Exception $e) {
            $bd->rollBack();
            echo "Erro na atualização: " . $e->getMessage();
        }
    }
}
?>
