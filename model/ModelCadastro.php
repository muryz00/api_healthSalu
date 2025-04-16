<?php
include "Conexao.php";
include "Usuario.php";
include "Paciente.php";
include "Medico.php";

class Cadastro {

    public function cadastrar(Usuario $usuario, $dadosAdicionais) {
        $con = new Conexao();
        $bd = $con->pegarConexao();
        $bd->beginTransaction();

        try {
            // Insere na tabela `usuario`
            $sqlUsuario = "INSERT INTO usuario (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
            $stmUsuario = $bd->prepare($sqlUsuario);
            $stmUsuario->bindValue(1, $usuario->getNome());
            $stmUsuario->bindValue(2, $usuario->getEmail());
            $stmUsuario->bindValue(3, $usuario->getSenha());
            $stmUsuario->bindValue(4, $usuario->getTipo());
            $stmUsuario->execute();

            // Obtém o ID gerado para o usuário
            $usuarioId = $bd->lastInsertId();
            $usuario->setId($usuarioId);

            // Insere os dados na tabela específica, conforme o tipo
            if($usuario->getTipo() === "paciente") {
                if(!$dadosAdicionais instanceof Paciente) {
                    throw new Exception("Dados adicionais incompatíveis.");
                }
                $sqlPaciente = "INSERT INTO paciente (id, cpf, data_nascimento, telefone) VALUES (?, ?, ?, ?)";
                $stmPaciente = $bd->prepare($sqlPaciente);
                $stmPaciente->bindValue(1, $usuarioId);
                $stmPaciente->bindValue(2, $dadosAdicionais->getCpf());
                $stmPaciente->bindValue(3, $dadosAdicionais->getDataNasc());
                $stmPaciente->bindValue(4, $dadosAdicionais->getTelefone());
                $stmPaciente->execute();
            } else if($usuario->getTipo() === "medico") {
                if(!$dadosAdicionais instanceof Medico) {
                    throw new Exception("Dados adicionais incompatíveis.");
                }
                $sqlMedico = "INSERT INTO medico (id, cpf, crm, especialidade, telefone) VALUES (?, ?, ?, ?, ?)";
                $stmMedico = $bd->prepare($sqlMedico);
                $stmMedico->bindValue(1, $usuarioId);
                $stmMedico->bindValue(2, $dadosAdicionais->getCpf());
                $stmMedico->bindValue(3, $dadosAdicionais->getCrm());
                $stmMedico->bindValue(4, $dadosAdicionais->getEspecialidade());
                $stmMedico->bindValue(5, $dadosAdicionais->getTelefone());
                $stmMedico->execute();
            } else {
                throw new Exception("Tipo de usuário inválido.");
            }

            $bd->commit();
            echo "Cadastro realizado com sucesso!";
        } catch(Exception $e) {
            $bd->rollBack();
            echo "Erro ao realizar cadastro: " . $e->getMessage();
        }
    }
}
?>
