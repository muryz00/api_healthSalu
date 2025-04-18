<?php
    class Conexao {
        private static $instancia;

        public static function pegarConexao() {
            if (!isset(self::$instancia)) {
                try {
                    // Configurações do banco de dados usando variáveis de ambiente
                    $host = getenv('DB_HOST');
                    $port = getenv('DB_PORT');
                    $dbname = getenv('DB_NAME');
                    $user = getenv('DB_USER');
                    $password = getenv('DB_PASS');
                    // $ssl_ca = getenv('DB_SSL_CA'); // Caminho para o certificado SSL

                    // Configuração do DSN
                    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

                    // Configuração de opções do PDO
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ];

                    // Adiciona SSL se o certificado estiver configurado
                    // if ($ssl_ca) {
                    //     $options[PDO::MYSQL_ATTR_SSL_CA] = $ssl_ca;
                    // }

                    // Cria a instância do PDO
                    self::$instancia = new PDO($dsn, $user, $password, $options);
                } catch (PDOException $e) {
                    // Registra o erro e encerra a execução
                    error_log("Erro ao conectar ao banco de dados: " . $e->getMessage());
                    die("Erro ao conectar ao banco de dados. Verifique os logs para mais detalhes.");
                }
            }
            return self::$instancia;
        }
    }
?>