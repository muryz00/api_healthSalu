<?php
// Objeto Entidade Medico
class Medico {
    private $id, $nome, $cpf, $email, $telefone, $senha, $crm, $especialidade;

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getCpf(){
        return $this->cpf;
    }
    public function setCpf($cpf){
        $this->cpf = $cpf;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    public function getTelefone(){
        return $this->telefone;
    }
    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }

    public function getSenha(){
        return $this->senha;
    }
    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function getCrm(){
        return $this->crm;
    }
    public function setCrm($crm){
        $this->crm = $crm;
    }

    public function getEspecialidade(){
        return $this->especialidade;
    }
    public function setEspecialidade($especialidade){
        $this->especialidade = $especialidade;
    }
}
?>
