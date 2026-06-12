CREATE TABLE suspeitos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_suspeito VARCHAR(100) NOT NULL,
    alibi_noite VARCHAR(255),
    relacao_vitima VARCHAR(100),
    motivo_provavel VARCHAR(255),
    nivel_suspeita VARCHAR(20) NOT NULL,
    historico_criminal TINYINT(1) DEFAULT 0
);