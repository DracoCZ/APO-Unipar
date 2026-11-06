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
    <title>Cadastro de Endereço</title>
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
                    <li class="nav-item"><a class="nav-link" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Fretes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contentor do Formulário -->
    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="text-center mb-4 fw-bold">Registrar Novo Endereço</h2>
        
        <div class="card shadow-sm">
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
        
        <!-- Mostra a mensagem de sucesso ou erro aqui -->
        <?= $mensagem ?>
        
    </div>

</body>
</html>