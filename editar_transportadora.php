<?php
include 'conexao.php';

$mensagem = "";
$transp_atual = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome_empresa = $_POST['nome_empresa'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $modelo_veiculo = $_POST['modelo_veiculo'];
    $placa = $_POST['placa'];

    // Utilização de concatenação para evitar erros de sintaxe com aspas
    $sql = "UPDATE transportadoras SET 
                nome_empresa='" . $nome_empresa . "', 
                cpf_cnpj='" . $cpf_cnpj . "', 
                modelo_veiculo='" . $modelo_veiculo . "', 
                placa='" . $placa . "' 
            WHERE id='" . $id . "'";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div class='alert alert-success text-center mt-3'>Transportadora atualizada com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger text-center mt-3'>Erro: " . $conn->error . "</div>";
    }
}

if (isset($_GET['id_selecionado']) && !empty($_GET['id_selecionado'])) {
    $id_selecionado = $_GET['id_selecionado'];
    $resultado = $conn->query("SELECT * FROM transportadoras WHERE id = '" . $id_selecionado . "'");
    if ($resultado->num_rows > 0) {
        $transp_atual = $resultado->fetch_assoc();
    }
}

$lista_transp = $conn->query("SELECT id, nome_empresa FROM transportadoras");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Transportadora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-custom { background-color: #343a40; }
        .btn-custom { background-color: #5b58ff; color: white; border: none; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Gestor Logístico</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerar_frete.php">Fretes</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorio.php">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="text-center mb-4 fw-bold">Editar Transportadora Existente</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4 text-center">
                <form method="GET" action="editar_transportadora.php">
                    <label class="form-label text-muted fw-bold">Selecione a transportadora que deseja editar:</label>
                    <div class="input-group">
                        <select class="form-select" name="id_selecionado" required>
                            <option value="">Selecione...</option>
                            <?php while($t = $lista_transp->fetch_assoc()) { ?>
                                <option value="<?= $t['id'] ?>" <?= (isset($id_selecionado) && $id_selecionado == $t['id']) ? 'selected' : '' ?>>
                                    <?= $t['nome_empresa'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Carregar Dados</button>
                    </div>
                </form>
            </div>
        </div>

        <?= $mensagem ?>

        <?php if ($transp_atual != null): ?>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="editar_transportadora.php">
                    <input type="hidden" name="id" value="<?= $transp_atual['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label text-muted">Nome/Empresa</label>
                        <input type="text" class="form-control" name="nome_empresa" value="<?= $transp_atual['nome_empresa'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">CPF/CNPJ</label>
                        <input type="text" class="form-control" name="cpf_cnpj" value="<?= $transp_atual['cpf_cnpj'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Modelo do Veículo</label>
                        <input type="text" class="form-control" name="modelo_veiculo" value="<?= $transp_atual['modelo_veiculo'] ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted">Matrícula (Placa)</label>
                        <input type="text" class="form-control" name="placa" value="<?= $transp_atual['placa'] ?>" required>
                    </div>

                    <div class="d-grid text-center">
                        <button type="submit" class="btn btn-warning px-5 py-2 fw-bold text-white">Atualizar Dados</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>
        
    </div>
</body>
</html>