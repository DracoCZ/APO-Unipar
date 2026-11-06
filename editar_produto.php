<?php
// Inclui o ficheiro de ligação à base de dados
include 'conexao.php';

$mensagem = "";
$produto_atual = null;

// 1. Processa a atualização dos dados quando o formulário é guardado (UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $peso = $_POST['peso'];
    $comprimento = $_POST['comprimento'];
    $largura = $_POST['largura'];
    $altura = $_POST['altura'];
    $valor = $_POST['valor'];

    $sql = "UPDATE produtos SET 
                nome='$nome', peso='$peso', comprimento='$comprimento', 
                largura='$largura', altura='$altura', valor='$valor' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div class='alert alert-success text-center mt-3'>Produto atualizado com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger text-center mt-3'>Erro: " . $conn->error . "</div>";
    }
}

// 2. Busca os dados se o utilizador selecionou um produto no menu
if (isset($_GET['id_selecionado']) && !empty($_GET['id_selecionado'])) {
    $id_selecionado = $_GET['id_selecionado'];
    $resultado = $conn->query("SELECT * FROM produtos WHERE id = '$id_selecionado'");
    if ($resultado->num_rows > 0) {
        $produto_atual = $resultado->fetch_assoc();
    }
}

// 3. Busca todos os produtos para preencher a caixa de seleção
$lista_produtos = $conn->query("SELECT id, nome FROM produtos");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-custom { background-color: #343a40; }
        .btn-custom { background-color: #5b58ff; color: white; border: none; }
        .btn-custom:hover { background-color: #4a47e6; color: white; }
    </style>
</head>
<body>

    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Gestor Logístico</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerar_frete.php">Fretes</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorio.php">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="text-center mb-4 fw-bold">Editar Produto Existente</h2>
        
        <!-- Formulário 1: Selecionar qual produto editar (Usa GET) -->
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4 text-center">
                <form method="GET" action="editar_produto.php">
                    <label class="form-label text-muted fw-bold">Selecione o produto que deseja editar:</label>
                    <div class="input-group">
                        <select class="form-select" name="id_selecionado" required>
                            <option value="">Selecione...</option>
                            <?php while($p = $lista_produtos->fetch_assoc()) { ?>
                                <option value="<?= $p['id'] ?>" <?= (isset($id_selecionado) && $id_selecionado == $p['id']) ? 'selected' : '' ?>>
                                    <?= $p['nome'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Carregar Dados</button>
                    </div>
                </form>
            </div>
        </div>

        <?= $mensagem ?>

        <!-- Formulário 2: Exibe os dados apenas se um produto for selecionado (Usa POST) -->
        <?php if ($produto_atual != null): ?>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="editar_produto.php">
                    
                    <!-- Campo Oculto para enviar o ID do produto que está a ser editado -->
                    <input type="hidden" name="id" value="<?= $produto_atual['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label text-muted">Nome do Produto</label>
                        <input type="text" class="form-control" name="nome" value="<?= $produto_atual['nome'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Peso (kg)</label>
                        <input type="number" step="0.01" class="form-control" name="peso" value="<?= $produto_atual['peso'] ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Compr. (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="comprimento" value="<?= $produto_atual['comprimento'] ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Largura (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="largura" value="<?= $produto_atual['largura'] ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Altura (cm)</label>
                            <input type="number" step="0.01" class="form-control" name="altura" value="<?= $produto_atual['altura'] ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted">Valor (R$)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" name="valor" value="<?= $produto_atual['valor'] ?>" required>
                        </div>
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