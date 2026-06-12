<?php
// Verifique se a pasta 'config' realmente está um nível acima deste arquivo
require_once __DIR__ . '/../config/config.php';

class DatabaseSH
{
    private static $instance = null;
    private $conn;

    // Construtor privado impede acoplamento externo direto (Padrão Singleton)
    private function __construct()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        try {
            // Tenta criar a conexão PDO com o banco de dados
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            /**
             * Se falhar, exibe mensagem amigável e para a execução
             * Em produção, você logaria o erro e mostraria uma mensagem genérica
             */
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        // Verifica se a instância ainda não foi criada
        if (self::$instance === null) {
            // Cria a instância (chama o construtor privado)
            self::$instance = new DatabaseSH();
        }
        // Retorna a instância (já existente ou recém-criada)
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}