<?php
session_start();

$usuario_valido = 'admin';
$senha_valida = '123456';
$hash_senha_valida = password_hash($senha_valida, PASSWORD_DEFAULT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($usuario === $usuario_valido && password_verify($senha, $hash_senha_valida)) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $usuario;
        header("Location: index.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
include 'includes/header.php';
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        
        <div class="card-header text-center bg-white text-primary pt-5 pb-3 border-0" style="border-radius: 12px 12px 0 0;">
            <i class="bi bi-wallet2" style="font-size: 3rem;"></i>
            <h3 class="mt-2 mb-0 fw-bold text-dark">MyWallet</h3>
            <small class="text-muted">Gestão Financeira Inteligente</small>
        </div>

        <div class="card-body px-4 pb-4 bg-white">
            <?php if(isset($erro)): ?>
                <div class="alert alert-danger py-2 rounded-3 text-center fw-medium"><?= $erro ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label class="form-label text-muted fw-bold small">UTILIZADOR</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-primary"></i></span>
                        <input type="text" name="usuario" class="form-control border-start-0 bg-light" placeholder="admin" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted fw-bold small">PALAVRA-PASSE</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-primary"></i></span>
                        <input type="password" name="senha" class="form-control border-start-0 bg-light" placeholder="......" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                    ENTRAR NO SISTEMA
                </button>
            </form>
        </div>
        
        <div class="card-footer text-center bg-white border-0 pb-4 pt-1" style="border-radius: 0 0 12px 12px;">
            <small class="text-muted d-block mb-1">Projeto Acadêmico de PHP - Grupo 4 &copy; 2026</small>
            <small class="text-muted d-block fw-medium">Arthur Hernandes e Gustavo Castro de Oliveira</small>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>