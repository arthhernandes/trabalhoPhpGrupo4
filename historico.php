<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

if (isset($_GET['acao']) && $_GET['acao'] === 'zerar') {
    $_SESSION['transacoes'] = []; 
    header("Location: historico.php");
    exit;
}

$transacoes = $_SESSION['transacoes'] ?? [];

$saldos = calcularSaldos($transacoes);
$total_despesas = $saldos['despesas'];

include 'includes/header.php'; 
?>

<nav class="navbar navbar-expand bg-white shadow-sm mb-4 py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">
            <i class="bi bi-wallet2"></i> MyWallet
        </a>
        <a href="index.php" class="btn btn-sm btn-light text-secondary fw-medium rounded-pill px-3"><i class="bi bi-arrow-left"></i> Voltar ao Dashboard</a>
    </div>
</nav>

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">Histórico de Movimentações</h4>
        <a href="historico.php?acao=zerar" class="btn btn-danger rounded-pill px-3 shadow-sm" onclick="return confirm('Tem certeza que deseja apagar todo o histórico?');">
            <i class="bi bi-trash"></i> Zerar Mês
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle border-light">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th class="py-3">Data</th>
                            <th class="py-3">Descrição</th>
                            <th class="py-3">Categoria</th>
                            <th class="py-3">Valor</th>
                            <th class="py-3">Impacto</th>
                            <th class="py-3">% das Despesas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transacoes)): ?>
                            <tr>
                                <td colspan="6" class="text-muted py-5">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-light"></i>
                                    Nenhuma transação registrada ainda.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transacoes as $t): ?>
                                <tr>
                                    <td class="text-muted small"><?= $t['data'] ?></td>
                                    <td class="fw-bold text-dark"><?= $t['descricao'] ?></td>
                                    <td>
                                        <span class="badge rounded-pill <?= $t['tipo'] === 'Receita' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?> px-3 py-2">
                                            <?= $t['tipo'] ?>
                                        </span>
                                    </td>
                                    <td class="fw-medium text-secondary"><?= formatarMoeda($t['valor']) ?></td>
                                    
                                    <td class="<?= $t['tipo'] === 'Receita' ? 'text-success' : 'text-danger' ?> fw-bold">
                                        <?= $t['tipo'] === 'Receita' ? '+' : '-' ?> <?= formatarMoeda($t['valor']) ?>
                                    </td>

                                    <td class="fw-medium text-secondary">
                                        <?php 
                                        if ($t['tipo'] === 'Despesa' && $total_despesas > 0) {
                                            $porcentagem = ($t['valor'] / $total_despesas) * 100;
                                            echo number_format($porcentagem, 1, ',', '.') . '%';
                                        } else {
                                            echo '<span class="text-light">-</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>