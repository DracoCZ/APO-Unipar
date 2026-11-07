<?php
// Inclui o ficheiro de ligação à base de dados
include 'conexao.php';

$mensagem = "";

// Verifica se o utilizador clicou no botão de submeter o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    // Comando SQL para inserir os dados na tabela enderecos
    $sql = "INSERT INTO enderecos (rua, numero, bairro, cep, cidade, estado) 
            VALUES ('$rua', '$numero', '$bairro', '$cep', '$cidade', '$estado')";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div class='alert alert-success text-center mt-3'>Endereço registado com sucesso!</div>";
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
    <title>Cadastro de Endereço - Gestor Logístico</title>
    <!-- Importação do Bootstrap -->
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
                    <li class="nav-item"><a class="nav-link" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cadastro_endereco.php">Endereços</a></li>
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
        <h2 class="text-center mb-4 fw-bold">Registrar Novo Endereço</h2>
        
        <div class="card shadow-sm border-0 rounded">
            <div class="card-body p-4">
                <form method="POST" action="cadastro_endereco.php">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="rua" class="form-label text-muted">Rua</label>
                            <input type="text" class="form-control" id="rua" name="rua" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="numero" class="form-label text-muted">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bairro" class="form-label text-muted">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" required>
                    </div>

                    <div class="mb-3">
                        <label for="cep" class="form-label text-muted">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label for="cidade" class="form-label text-muted">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="estado" class="form-label text-muted">Estado (UF)</label>
                            <input type="text" class="form-control" id="estado" name="estado" maxlength="2" required>
                        </div>
                    </div>

                    <div class="d-grid text-center">
                        <button type="submit" class="btn btn-custom px-5 py-2">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Mostra a mensagem de sucesso ou erro -->
        <?= $mensagem ?>
        
    </div>

    <!-- JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>