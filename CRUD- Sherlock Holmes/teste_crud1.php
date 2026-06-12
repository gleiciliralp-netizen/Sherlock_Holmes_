<?php
require_once __DIR__ . '/holmes/HOLMES.php';
require_once __DIR__ . '/model/sherlock.php';

echo "<h1>🚀 Teste Completo do CRUD</h1>";
echo "<hr>";

// Instanciando a classe correta de banco (DAO)
$holmes = new HOLMES();
$idTeste = null;

echo "<h2>📝 1. Teste CREATE</h2>";
// Criando o objeto do modelo 'sherlock' com os dados do suspeito
// Passando o último parâmetro como booleano (false para "Não")
$pasta = new sherlock(null, "Carlos Antunes", "Faculdade", "Namorado", "Ciúmes", "Alto", false);
$idTeste = $holmes->create($pasta);

if ($idTeste) {
    echo "✅ CREATE ok! ID gerado: $idTeste<br>";
} else {
    echo "❌ CREATE falhou<br>";
}
echo "<hr>";

echo "<h2>🔍 2. Teste READ BY ID</h2>";
// Buscando o suspeito recém-criado no banco de dados
$pastaencontrada = $holmes->readById($idTeste);

if ($pastaencontrada) {
    echo "✅ READ BY ID ok!<br><br>";

    // Exibindo os dados utilizando os métodos corretos do arquivo sherlock.php
    echo "<strong>ID:</strong> " . $pastaencontrada->getId() . "<br>";
    echo "<strong>Nome do Suspeito:</strong> " . $pastaencontrada->getNome_suspeito() . "<br>";
    echo "<strong>Álibi:</strong> " . $pastaencontrada->getAlibi_noite() . "<br>";
    echo "<strong>Relação com a vítima:</strong> " . $pastaencontrada->getRelacaovitima() . "<br>";
    echo "<strong>Motivação Provável:</strong> " . $pastaencontrada->getMotivoprovavel() . "<br>";
    echo "<strong>Nível de Suspeita:</strong> " . $pastaencontrada->getNivelsuspeita() . "<br>";
    
    // Formatando o booleano para exibição limpa
    $historico = $pastaencontrada->getHistoricocriminal() ? "Sim" : "Não";
    echo "<strong>Histórico Criminal?:</strong> " . $historico . "<br>";
} else {
    echo "❌ READ BY ID falhou ou o registro não foi encontrado.<br>";
}
echo "<hr>";