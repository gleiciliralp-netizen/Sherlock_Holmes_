<?php
require_once  __DIR__ . '/holmes/HOLMES.php';
require_once  __DIR__ . '/model/sherlock.php'; 

$mensagem = '';
// Instanciamos o DAO aqui em cima para usá-lo tanto no cadastro quanto na listagem abaixo
$holmes = new HOLMES();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome_suspeito      = $_POST['nome_suspeito'] ?? '';
    $alibi_noite        = $_POST['alibi_noite'] ?? '';
    $relacao_vitima     = $_POST['relacao_vitima'] ?? '';
    $motivo_provavel    = $_POST['motivo_provavel'] ?? '';
    $nivel_suspeita     = $_POST['nivel_suspeita'] ?? '';
    $historico_criminal = $_POST['historico_criminal'] ?? false;

    $pasta = new sherlock(null, $nome_suspeito, $alibi_noite, $relacao_vitima, $motivo_provavel, $nivel_suspeita, $historico_criminal);

    $id = $holmes->create($pasta);
    if ($id) {
        $mensagem = "Suspeito cadastrado com sucesso! ID: $id";
    } else {
        $mensagem = "Erro ao cadastrar";
    }
}

// Busca todos os suspeitos reais salvos no banco de dados para listar na tabela abaixo
$listaSuspeitos = $holmes->readAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de suspeitos</title>
</head>
<body>
    <div class="container">
    <h1>Investigação: Controle de Suspeitos</h1>
    
    <?php if(!empty($mensagem)): ?>
        <p><strong><?php echo $mensagem; ?></strong></p>
    <?php endif; ?>
    
    <hr>
    <h2>Cadastrar Novo Suspeito</h2>
    <form action="createSH.php" method="POST">
        <div class="form-group">
            <label for="nome_suspeito">Nome do Suspeito *</label>
            <input type="text" id="nome_suspeito" name="nome_suspeito" required>
        </div>

        <div class="form-group">
            <label for="alibi_noite">Álibi da Noite</label>
            <textarea id="alibi_noite" name="alibi_noite" rows="2"></textarea>
        </div>

        <div class="form-group">
            <label for="relacao_vitima">Relação com a Vítima</label>
            <input type="text" id="relacao_vitima" name="relacao_vitima">
        </div>

        <div class="form-group">
            <label for="motivo_provavel">Motivação Provável</label>
            <textarea id="motivo_provavel" name="motivo_provavel" rows="2"></textarea>
        </div>

        <div class="form-group">
            <label for="nivel_suspeita">Nível de Suspeita </label>
            <select id="nivel_suspeita" name="nivel_suspeita" required>
                <option value="">Selecione...</option>
                <option value="Baixo">Baixo</option>
                <option value="Médio">Médio</option>
                <option value="Alto">Alto</option>
            </select>
        </div>

        <div class="form-group">
            <label>Histórico Criminal? *</label>
            <div class="radio-group">
                <input type="radio" id="hist_nao" name="historico_criminal" value="0" checked>
                <label for="hist_nao" class="label-inline">Não</label>
                
                <input type="radio" id="hist_sim" name="historico_criminal" value="1">
                <label for="hist_sim" class="label-inline">Sim</label>
            </div>
        </div>

        <button type="submit" class="btn-salvar">Salvar Suspeito</button>
    </form>

    <br><hr><br>

    <h2>Suspeitos Cadastrados</h2>
    <table class="tabela-suspeitos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Nível de Suspeita</th>
                <th>Histórico Criminal</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($listaSuspeitos)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Nenhum suspeito cadastrado até o momento.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($listaSuspeitos as $suspeito): ?>
                    <tr>
                        <td><?php echo $suspeito->getId(); ?></td>
                        <td><?php echo htmlspecialchars($suspeito->getNome_suspeito()); ?></td>
                        <td><?php echo htmlspecialchars($suspeito->getNivelsuspeita()); ?></td>
                        <td><?php echo $suspeito->getHistoricocriminal() ? 'Sim' : 'Não'; ?></td>
                        <td>
                            <a href="editarSh.php?id=<?php echo $suspeito->getId(); ?>" class="link-editar">Editar</a>
                            <a href="deleteSH.php?id=<?php echo $suspeito->getId(); ?>" class="link-excluir" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>