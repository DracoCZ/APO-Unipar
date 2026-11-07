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
    <title>Cadastro de Transportadora - Gestor Logístico</title>
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
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerar_frete.php">Frete</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorio.php">Relatorios</a></li>
                    <li class="nav-item"><a class="nav-link" href="editar_geral.php">Central de Edição</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contentor do Formulário -->
    <div class="container mt-4 mb-5" style="max-width: 600px;">
        <h2 class="text-center mb-4 fw-bold">Registrar Nova Transportadora</h2>
        
        <div class="card shadow-sm border-0 rounded">
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
        
        <!-- Mostra a mensagem de sucesso ou erro -->
        <?= $mensagem ?>
        
    </div>

    <!-- JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>