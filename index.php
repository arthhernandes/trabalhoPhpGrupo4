<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

if (!isset($_SESSION['transacoes'])) {
    $_SESSION['transacoes'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descricao'], $_POST['valor'], $_POST['tipo'])) {
    $nova_transacao = [
        'data' => date('d/m/Y H:i'),
        'descricao' => htmlspecialchars($_POST['descricao']), 
        'valor' => floatval(str_replace(',', '.', $_POST['valor'])), 
        'tipo' => $_POST['tipo']
    ];
    
    $_SESSION['transacoes'][] = $nova_transacao;
    
    header("Location: index.php");
    exit;
}

$saldos = calcularSaldos($_SESSION['transacoes']);

include 'includes/header.php'; 
?>

<nav class="navbar navbar-expand bg-white shadow-sm mb-4 py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">
            <i class="bi bi-wallet2"></i> MyWallet
        </a>
        <div class="d-flex align-items-center">
            <span class="text-secondary me-3 fw-medium">Olá, <?= htmlspecialchars($_SESSION['usuario']) ?></span>
            <a href="logout.php" class="btn btn-sm btn-outline-danger px-3 rounded-pill">Sair</a>
        </div>
    </div>
</nav>

<div class="container">
    
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 border-top border-4 border-success rounded-3 shadow-sm">
                <div class="card-body py-4">
                    <div class="text-muted small fw-bold mb-2 text-uppercase">Total Receitas</div>
                    <h3 class="text-success fw-bold mb-0"><?= formatarMoeda($saldos['receitas']) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 border-top border-4 border-danger rounded-3 shadow-sm">
                <div class="card-body py-4">
                    <div class="text-muted small fw-bold mb-2 text-uppercase">Total Despesas</div>
                    <h3 class="text-danger fw-bold mb-0"><?= formatarMoeda($saldos['despesas']) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 bg-primary text-white shadow">
                <div class="card-body py-4">
                    <div class="text-white-50 small fw-bold mb-2 text-uppercase">Saldo Disponível</div>
                    <h3 class="fw-bold mb-0"><?= formatarMoeda($saldos['saldo']) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="fw-bold text-dark"><i class="bi bi-plus-circle text-primary me-2"></i>Nova Transação</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="index.php" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label text-muted small fw-bold">Descrição</label>
                    <input type="text" name="descricao" class="form-control bg-light border-0" placeholder="Ex: Salário, Aluguel..." required>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small fw-bold">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted">R$</span>
                        <input type="number" step="0.01" name="valor" class="form-control bg-light border-0" placeholder="0.00" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted small fw-bold">Tipo</label>
                    <select name="tipo" class="form-select bg-light border-0" required>
                        <option value="Receita">Receita</option>
                        <option value="Despesa">Despesa</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Adicionar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mb-5">
        <a href="historico.php" class="btn btn-outline-primary px-4 py-2 rounded-pill fw-medium">Ver Detalhes do Histórico</a>
    </div>

</div>

<?php include 'includes/footer.php'; ?>