<?php

    class Conexao{
       private static $instancia;
       public static function pegarConexao(){
            if(!isset(self::$instancia)) {
                self::$instancia = new PDO(
                    "mysql:host=localhost; dbname=api_cadastro;
                    charset=utf8", "root", "");
            }
            return self::$instancia;   
       } 
    }
?>