<?php
require_once __DIR__ . '/../core/DatabaseSH.php';
require_once __DIR__ . '/../model/sherlock.php';

class HOLMES { 
    private $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseSH::getInstance()->getConnection();
    }

    public function create(sherlock $pasta)
    {
        // AJUSTADO: tabela 'suspeitos' e coluna 'motivo_provavel'
        $sql = "INSERT INTO suspeitos (nome_suspeito, alibi_noite, relacao_vitima, motivo_provavel, nivel_suspeita, historico_criminal) 
                VALUES (:nome_suspeito, :alibi_noite, :relacao_vitima, :motivo_provavel, :nivel_suspeita, :historico_criminal)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome_suspeito', $pasta->getNome_suspeito()); 
        $stmt->bindValue(':alibi_noite', $pasta->getAlibi_noite());
        $stmt->bindValue(':relacao_vitima', $pasta->getRelacaovitima());
        $stmt->bindValue(':motivo_provavel', $pasta->getMotivoprovavel());
        $stmt->bindValue(':nivel_suspeita', $pasta->getNivelsuspeita());
        $stmt->bindValue(':historico_criminal', $pasta->getHistoricocriminal(), PDO::PARAM_BOOL);

        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function readAll()
    {
        // AJUSTADO: tabela 'suspeitos'
        $sql = "SELECT * FROM suspeitos ORDER BY id";
        $stmt = $this->pdo->query($sql);

        $lista = [];
        while ($row = $stmt->fetch()) {
            $lista[] = new sherlock(
                $row['id'],
                $row['nome_suspeito'],
                $row['alibi_noite'],
                $row['relacao_vitima'],
                $row['motivo_provavel'], // AJUSTADO: coluna 'motivo_provavel'
                $row['nivel_suspeita'],
                $row['historico_criminal']
            );
        }
        return $lista;
    }

    public function readById($id)
    {
        // AJUSTADO: tabela 'suspeitos'
        $sql = "SELECT * FROM suspeitos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($row = $stmt->fetch()) {
            return new sherlock(
                $row['id'],
                $row['nome_suspeito'],
                $row['alibi_noite'],
                $row['relacao_vitima'],
                $row['motivo_provavel'], // AJUSTADO: coluna 'motivo_provavel'
                $row['nivel_suspeita'],
                $row['historico_criminal']
            );
        }
        return null;
    }

    public function update(sherlock $pasta)
    {
        // AJUSTADO: tabela 'suspeitos' e coluna 'motivo_provavel'
        $sql = "UPDATE suspeitos SET 
                nome_suspeito = :nome_suspeito, 
                alibi_noite = :alibi_noite, 
                relacao_vitima = :relacao_vitima, 
                motivo_provavel = :motivo_provavel, 
                nivel_suspeita = :nivel_suspeita, 
                historico_criminal = :historico_criminal 
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $pasta->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':nome_suspeito', $pasta->getNome_suspeito()); 
        $stmt->bindValue(':alibi_noite', $pasta->getAlibi_noite());
        $stmt->bindValue(':relacao_vitima', $pasta->getRelacaovitima());
        $stmt->bindValue(':motivo_provavel', $pasta->getMotivoprovavel());
        $stmt->bindValue(':nivel_suspeita', $pasta->getNivelsuspeita());
        $stmt->bindValue(':historico_criminal', $pasta->getHistoricocriminal());

        return $stmt->execute();
    }

    public function delete($id)
    {
        // AJUSTADO: tabela 'suspeitos'
        $sql = "DELETE FROM suspeitos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}