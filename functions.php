<?php
function calcularSaldos($transacoes) {
    $receitas = 0;
    $despesas = 0;

    foreach ($transacoes as $t) {
        if ($t['tipo'] === 'Receita') {
            $receitas += $t['valor'];
        } elseif ($t['tipo'] === 'Despesa') {
            $despesas += $t['valor'];
        }
    }

    $saldo = $receitas - $despesas;

    return [
        'receitas' => $receitas,
        'despesas' => $despesas,
        'saldo' => $saldo
    ];
}

function formatarMoeda($valor) {
    return "R$ " . number_format($valor, 2, ',', '.');
}
?>