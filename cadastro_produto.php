<?php
// Inclui o ficheiro de ligação à base de dados
include 'conexao.php';

$mensagem = "";

// Verifica se o utilizador clicou no botão de submeter o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $peso = $_POST['peso'];
    $comprimento = $_POST['comprimento'];
    $largura = $_POST['largura'];
    $altura = $_POST['altura'];
    $valor = $_POST['valor'];

    // Comando SQL para inserir os dados
    $sql = "INSERT INTO produtos (nome, peso, comprimento, largura, altura, valor) 
            VALUES ('$nome', '$peso', '$comprimento', '$largura', '$altura', '$valor')";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div class='alert alert-success text-center mt-3'>Produto registado com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger text-center mt-3'>Erro: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto - Gestor Logístico</title>
    <!-- Importação do Bootstrap para o design -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* NAVBAR PADRONIZADA */
        .navbar-custom { background-color: #3b3f45; }
        .navbar-custom .nav-link { color: #a9a9a9; padding: 8px 16px; margin: 0 4px; }
        .navbar-custom .nav-link:hover { color: #ffffff; }
        .navbar-custom .nav-link.active { color: #ffffff; font-weight: 500; background-color: #555960; border-radius: 4px; }
        
        .btn-custom { background-color: #5b58ff; color: white; border: none; }
        .btn-custom:hover { background-color: #4a47e6; color: white; }
    </style>
</head>
<body>

    <!-- BARRA DE NAVEGAÇÃO PADRONIZADA -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3 mb-4">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerar_frete.php">Frete</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorio.php">Relatorios</a></li>
                    <li class="nav-item"><a class="nav-link" href="editar_geral.php">Central de Edição</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contentor do Formulário -->
    <div class="container mt-4 mb-5" style="max-width: 600px;">
        <h2 class="text-center mb-4 fw-bold">Registrar Novo Produto</h2>
        
        <div class="card shadow-sm border-0 rounded">
            <div class="card-body p-4">
                <form method="POST" action="cadastro_produto.php">
                    <div class="mb-3">
                        <label for="nome" class="form-label text-muted">Nome do Produto</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="peso" class="form-label text-muted">Peso (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="peso" name="peso" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="comprimento" class="form-label text-muted">Comprimento (cm)</label>
                            <input type="number" step="0.01" class="form-control" id="comprimento" name="comprimento" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="largura" class="form-label text-muted">Largura (cm)</label>
                            <input type="number" step="0.01" class="form-control" id="largura" name="largura" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="altura" class="form-label text-muted">Altura (cm)</label>
                            <input type="number" step="0.01" class="form-control" id="altura" name="altura" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="valor" class="form-label text-muted">Valor (R$)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
                        </div>
                    </div>

                    <div class="d-grid text-center">
                        <button type="submit" class="btn btn-custom px-5 py-2">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Mostra a mensagem de sucesso ou erro aqui -->
        <?= $mensagem ?>
        
    </div>

    <!-- JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>