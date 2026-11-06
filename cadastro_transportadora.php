<?php
// Inclui o ficheiro de ligação à base de dados
include 'conexao.php';

$mensagem = "";

// Verifica se o utilizador clicou no botão de submeter o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_empresa = $_POST['nome_empresa'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $modelo_veiculo = $_POST['modelo_veiculo'];
    $placa = $_POST['placa'];

    // Comando SQL para inserir os dados na tabela transportadoras
    $sql = "INSERT INTO transportadoras (nome_empresa, cpf_cnpj, modelo_veiculo, placa) 
            VALUES ('$nome_empresa', '$cpf_cnpj', '$modelo_veiculo', '$placa')";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div class='alert alert-success text-center mt-3'>Transportadora registada com sucesso!</div>";
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
    <title>Cadastro de Transportadora</title>
    <!-- Importação do Bootstrap para o design -->
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
                    <li class="nav-item"><a class="nav-link active" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Fretes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contentor do Formulário -->
    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="text-center mb-4 fw-bold">Registrar Nova Transportadora</h2>
        
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="cadastro_transportadora.php">
                    <div class="mb-3">
                        <label for="nome_empresa" class="form-label text-muted">Nome/Empresa</label>
                        <input type="text" class="form-control" id="nome_empresa" name="nome_empresa" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cpf_cnpj" class="form-label text-muted">CPF/CNPJ</label>
                        <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
                    </div>

                    <div class="mb-3">
                        <label for="modelo_veiculo" class="form-label text-muted">Modelo do Veículo</label>
                        <input type="text" class="form-control" id="modelo_veiculo" name="modelo_veiculo" required>
                    </div>

                    <div class="mb-4">
                        <label for="placa" class="form-label text-muted">Matrícula (Placa)</label>
                        <input type="text" class="form-control" id="placa" name="placa" required>
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