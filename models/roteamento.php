<?php 

class Roteamento{

    protected $uri;

    protected $rotasGet;

    protected $rotasPost;

    protected $rotasPut;

    protected  $rotasDelete;

    public function __construct($rotasGet = [], $rotasPost = [],  $rotasPut = [], $rotasDelete = []) {

        $this->rotasGet = $rotasGet;

        $this->rotasPost = $rotasPost;

        $this->rotasPut = $rotasPut;

        $this->rotasDelete = $rotasDelete;

        $this->uri = $this->extrairUrl();
    }

     protected function rotearGet($nomeRota) {
        if(array_key_exists($nomeRota, $this->rotasGet)){
            require_once $_SERVER['DOCUMENT_ROOT'].$this->rotasGet[$nomeRota];
            
        }else{
            echo 'Não encontrado';  
        }
    }

     protected function rotearPost($nomeRota){    
        if(array_key_exists($nomeRota, $this->rotasPost)){
            require_once $_SERVER['DOCUMENT_ROOT'].$this->rotasPost[$nomeRota];
        }else{
            echo 'Não encontrado';  
        }
                  
    }

     protected function rotearPut($nomeRota){ 
        if(array_key_exists($nomeRota, $this->rotasPut)){
            require_once $_SERVER['DOCUMENT_ROOT'].$this->rotasPut[$nomeRota];
            
        }else{
            echo 'Não encontrado';  
        }
          
    }

     protected function rotearDelete($nomeRota){
        if(array_key_exists($nomeRota, $this->rotasDelete)){
            require_once $_SERVER['DOCUMENT_ROOT'].$this->rotasDelete[$nomeRota];
            
        }else{
            echo 'Não encontrado';  
        }
    }

    protected function extrairUrl(){
        $str = $_SERVER['REQUEST_URI'];
        $str = explode('?', $str);
        $uri = $str[0];
        return $uri;
    }
    
    public function ativar()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->rotearGet($this->uri);
                break;
            case 'POST':
                $this->rotearPost($this->uri);
                break;
            case 'PUT':
                $this->rotearPut($this->uri);
                break;
            case 'DELETE':
                $this->rotearDelete($this->uri);
                break;
        }
    }
}