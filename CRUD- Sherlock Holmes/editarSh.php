<?php
require_once __DIR__ . '/holmes/HOLMES.php';
require_once __DIR__ . '/model/sherlock.php';

$holmes = new HOLMES();
$mensagem = '';

// Recupera o ID da URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Busca o suspeito pelo ID
$suspeito = $holmes->readById($id);

// Verifica se o suspeito existe
if (!$suspeito) {
    die("Suspeito não encontrado. <a href='createSH.php'>Voltar à lista</a>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $nome_suspeito      = $_POST['nome_suspeito'] ?? '';
    $alibi_noite        = $_POST['alibi_noite'] ?? '';
    $relacao_vitima     = $_POST['relacao_vitima'] ?? '';
    $motivo_provavel    = $_POST['motivo_provavel'] ?? '';
    $nivel_suspeita     = $_POST['nivel_suspeita'] ?? '';
    $historico_criminal = (bool)($_POST['historico_criminal'] ?? 0);

    // Cria um novo objeto sherlock com os dados atualizados para enviar ao UPDATE
    $suspeitoAtualizado = new sherlock(
        $id, 
        $nome_suspeito, 
        $alibi_noite, 
        $relacao_vitima, 
        $motivo_provavel, 
        $nivel_suspeita, 
        $historico_criminal
    );

    // Tenta atualizar no banco de dados
    if ($holmes->update($suspeitoAtualizado)) {
        $mensagem = "Suspeito atualizado com sucesso!";
        // Recarrega os dados atualizados para exibir corretamente no formulário
        $suspeito = $holmes->readById($id);
    } else {
        $mensagem = "Erro ao atualizar suspeito.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Suspeito</title>
</head>
<body>
    <div class="container" style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>✏️ Editando Suspeito: <?= htmlspecialchars($suspeito->getNome_suspeito()) ?></h2>

        <?php if (!empty($mensagem)): ?>
            <p style="background: #e3f2fd; padding: 10px; border-left: 5px solid #2196f3;">
                <strong><?= htmlspecialchars($mensagem) ?></strong>
            </p>
        <?php endif; ?>

        <hr>

        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label for="nome_suspeito"><strong>Nome do Suspeito *</strong></label><br>
                <input type="text" id="nome_suspeito" name="nome_suspeito" style="width: 100%;" required
                    value="<?= htmlspecialchars($suspeito->getNome_suspeito()) ?>">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="alibi_noite"><strong>Álibi da Noite</strong></label><br>
                <textarea id="alibi_noite" name="alibi_noite" rows="2" style="width: 100%;"><?= htmlspecialchars($suspeito->getAlibi_noite()) ?></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="relacao_vitima"><strong>Relação com a Vítima</strong></label><br>
                <input type="text" id="relacao_vitima" name="relacao_vitima" style="width: 100%;"
                    value="<?= htmlspecialchars($suspeito->getRelacaovitima()) ?>">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="motivo_provavel"><strong>Motivação Provável</strong></label><br>
                <textarea id="motivo_provavel" name="motivo_provavel" rows="2" style="width: 100%;"><?= htmlspecialchars($suspeito->getMotivoprovavel()) ?></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="nivel_suspeita"><strong>Nível de Suspeita *</strong></label><br>
                <select id="nivel_suspeita" name="nivel_suspeita" style="width: 100%;" required>
                    <option value="Baixo" <?= $suspeito->getNivelsuspeita() === 'Baixo' ? 'selected' : '' ?>>Baixo</option>
                    <option value="Médio" <?= $suspeito->getNivelsuspeita() === 'Médio' ? 'selected' : '' ?>>Médio</option>
                    <option value="Alto" <?= $suspeito->getNivelsuspeita() === 'Alto' ? 'selected' : '' ?>>Alto</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label><strong>Histórico Criminal? *</strong></label><br>
                <input type="radio" id="hist_nao" name="historico_criminal" value="0" <?= !$suspeito->getHistoricocriminal() ? 'checked' : '' ?>>
                <label for="hist_nao">Não</label>
                
                <input type="radio" id="hist_sim" name="historico_criminal" value="1" <?= $suspeito->getHistoricocriminal() ? 'checked' : '' ?>>
                <label for="hist_sim">Sim</label>
            </div>

            <button type="submit" style="background: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer;">Atualizar Suspeito</button>
            <a href="createSH.php" style="margin-left: 15px; text-decoration: none; color: #333;">↩ Voltar para a lista</a>
        </form>
    </div>
</body>
</html>