<?php

class Pagina {

    protected $id;
    protected $titulo;
    protected $tag_titulo;
    protected $conteudo;

    public function getId(){
        return $this->id;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function getTag_titulo(){
        return $this->tag_titulo;
    }

    public function getConteudo(){
        return $this->conteudo;
    }

    public function setId($id){
        return $this->id = $id;
    }

    public function setTitulo($titulo){
        return $this->titulo = $titulo;
    }

    public function setTag_titulo($tag_titulo){
        return $this->tag_titulo = $tag_titulo;
    }

    public function setConteudo($conteudo){
        return $this->conteudo = $conteudo;
    }

    public function getArrayCopy(){
        return get_object_vars($this);
    }

    public function exchangeArray($data){
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->titulo = (isset($data['titulo'])) ? $data['titulo'] : null;
        $this->tag_titulo = (isset($data['tag_titulo'])) ? $data['tag_titulo'] : null;
        $this->conteudo = (isset($data['conteudo'])) ? $data['conteudo'] : null;
    }

}