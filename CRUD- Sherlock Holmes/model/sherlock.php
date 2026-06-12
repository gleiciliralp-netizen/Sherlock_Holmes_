<?php
class sherlock { // Corrigido de Sherlocks para sherlock
    private ?int $id;
    private ?string $nome_suspeito;
    private ?string $alibi_noite;
    private ?string $relacao_vitima;
    private ?string $motivo_provavel;
    private ?string $nivel_suspeita;
    private ?bool $historico_criminal;

    public function __construct($id = null, $nome_suspeito = null, $alibi_noite = null, $relacao_vitima = null, $motivo_provavel = null, $nivel_suspeita = null, $historico_criminal = false)
    {
        $this->id = $id;
        $this->nome_suspeito = $nome_suspeito;
        $this->alibi_noite = $alibi_noite;
        $this->relacao_vitima = $relacao_vitima;
        $this->motivo_provavel = $motivo_provavel;
        $this->nivel_suspeita = $nivel_suspeita;
        $this->historico_criminal = $historico_criminal;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome_suspeito(): ?string
    {
        return $this->nome_suspeito;
    }

    public function getAlibi_noite(): ?string
    {
        return $this->alibi_noite;
    }

    public function getRelacaovitima(): ?string
    {
        return $this->relacao_vitima;
    }

    public function getMotivoprovavel(): ?string
    {
        return $this->motivo_provavel;
    }

    public function getNivelsuspeita(): ?string
    {
        return $this->nivel_suspeita; // Corrigido: adicionado o 's' que faltava
    }

    public function getHistoricocriminal(): ?bool
    {
        return $this->historico_criminal;
    }

    // Setters omitidos aqui para encurtar, mas mantenha-os se usar.
}
