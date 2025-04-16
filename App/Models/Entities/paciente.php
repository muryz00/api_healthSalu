<?php
// Objeto Entidade Paciente
class Paciente {
    private $id, $nome, $cpf, $dataNasc, $email, $telefone, $senha;

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

    public function getDataNasc(){
        return $this->dataNasc;
    }
    public function setDataNasc($dataNasc){
        $this->dataNasc = $dataNasc;
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
}
?>
