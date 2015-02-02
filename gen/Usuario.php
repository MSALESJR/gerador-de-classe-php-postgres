<?php

class Usuario {

    protected $id;
    protected $nome;
    protected $email;
    protected $senha;

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setId($id){
        return $this->id = $id;
    }

    public function setNome($nome){
        return $this->nome = $nome;
    }

    public function setEmail($email){
        return $this->email = $email;
    }

    public function setSenha($senha){
        return $this->senha = $senha;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public function exchangeArray($data){
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->senha = (isset($data['senha'])) ? $data['senha'] : null;
    }

}