<?php
// Inclui o ficheiro de ligação à base de dados
include 'conexao.php';

$mensagem = "";

// Lógica para processar o formulário quando for submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transportadora_id = $_POST['transportadora_id'];
    $origem_id = $_POST['origem_id'];
    $destino_id = $_POST['destino_id'];
    $data_frete = $_POST['data_frete'];
    $custo_total = $_POST['custo_total'];
    $produtos = $_POST['produtos']; // Recebe um array com os IDs dos produtos
    $quantidades = $_POST['quantidades']; // Recebe um array com as quantidades

    // 1. Inserir os dados principais na tabela 'fretes'
    $sql_frete = "INSERT INTO fretes (transportadora_id, origem_id, destino_id, data_frete, custo_total) 
                  VALUES ('$transportadora_id', '$origem_id', '$destino_id', '$data_frete', '$custo_total')";
    
    if ($conn->query($sql_frete) === TRUE) {
        $frete_id = $conn->insert_id; // Pega o ID gerado automaticamente para o frete criado

        // 2. Inserir os múltiplos produtos na tabela 'frete_produtos'
        $erro_produtos = false;
        for ($i = 0; $i < count($produtos); $i++) {
            $produto_id = $produtos[$i];
            $quantidade = $quantidades[$i];

            if (!empty($produto_id) && !empty($quantidade)) {
                $sql_frete_produto = "INSERT INTO frete_produtos (frete_id, produto_id, quantidade) 
                                      VALUES ('$frete_id', '$produto_id', '$quantidade')";
                if (!$conn->query($sql_frete_produto)) {
                    $erro_produtos = true;
                }
            }
        }

        if (!$erro_produtos) {
            $mensagem = "<div class='alert alert-success text-center mt-3'>Frete gerado com sucesso! Múltiplos produtos associados.</div>";
        } else {
            $mensagem = "<div class='alert alert-warning text-center mt-3'>Frete criado, mas houve um erro ao associar alguns produtos.</div>";
        }
    } else {
        $mensagem = "<div class='alert alert-danger text-center mt-3'>Erro ao criar frete: " . $conn->error . "</div>";
    }
}

// Buscar dados à base de dados para preencher as caixas de seleção
$transportadoras = $conn->query("SELECT id, nome_empresa FROM transportadoras");
$produtos_lista = $conn->query("SELECT id, nome, valor FROM produtos");

// Armazenar os produtos numa variável de texto para a podermos usar no JavaScript
$opcoes_produtos = "";
while($prod = $produtos_lista->fetch_assoc()) {
    $opcoes_produtos .= "<option value='" . $prod['id'] . "'>" . $prod['nome'] . " (R$ " . $prod['valor'] . ")</option>";
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Frete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-custom { background-color: #343a40; }
        .btn-custom { background-color: #5b58ff; color: white; border: none; }
        .btn-custom:hover { background-color: #4a47e6; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Gestor Logístico</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link active" href="gerar_frete.php">Fretes</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 800px;">
        <h2 class="text-center mb-4 fw-bold">Gerar Novo Frete</h2>
        
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="gerar_frete.php">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Transportadora</label>
                            <select class="form-select" name="transportadora_id" required>
                                <option value="">Selecione a transportadora...</option>
                                <?php while($t = $transportadoras->fetch_assoc()) { ?>
                                    <option value="<?= $t['id'] ?>"><?= $t['nome_empresa'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Data do Frete</label>
                            <input type="date" class="form-control" name="data_frete" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Endereço de Origem</label>
                            <select class="form-select" name="origem_id" required>
                                <option value="">Selecione a origem...</option>
                                <?php 
                                $enderecos_origem = $conn->query("SELECT id, rua, cidade, estado FROM enderecos");
                                while($end = $enderecos_origem->fetch_assoc()) { ?>
                                    <option value="<?= $end['id'] ?>"><?= $end['rua'] ?> - <?= $end['cidade'] ?>/<?= $end['estado'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Endereço de Destino</label>
                            <select class="form-select" name="destino_id" required>
                                <option value="">Selecione o destino...</option>
                                <?php 
                                $enderecos_destino = $conn->query("SELECT id, rua, cidade, estado FROM enderecos");
                                while($end = $enderecos_destino->fetch_assoc()) { ?>
                                    <option value="<?= $end['id'] ?>"><?= $end['rua'] ?> - <?= $end['cidade'] ?>/<?= $end['estado'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Produtos a Transportar</h5>
                    
                    <!-- DIV onde o JavaScript vai injetar os novos campos de produtos -->
                    <div id="lista-produtos">
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <select class="form-select" name="produtos[]" required>
                                    <option value="">Selecione um Produto...</option>
                                    <?= $opcoes_produtos ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" name="quantidades[]" placeholder="Quantidade" min="1" required>
                            </div>
                        </div>
                    </div>

                    <!-- Botão que chama a função JavaScript -->
                    <button type="button" class="btn btn-outline-secondary btn-sm mb-4" onclick="adicionarProduto()">+ Adicionar outro produto</button>

                    <div class="mb-4">
                        <label class="form-label text-muted">Custo Total (R$)</label>
                        <input type="number" step="0.01" class="form-control" name="custo_total" required>
                    </div>

                    <div class="d-grid text-center">
                        <button type="submit" class="btn btn-custom px-5 py-2">Concluir Frete</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?= $mensagem ?>
    </div>

    <!-- O Módulo de JavaScript exigido pela atividade -->
    <script>
        function adicionarProduto() {
            var container = document.getElementById('lista-produtos');
            var novaLinha = document.createElement('div');
            novaLinha.className = 'row mb-2';
            
            // Repete o código HTML do produto
            novaLinha.innerHTML = `
                <div class="col-md-8">
                    <select class="form-select" name="produtos[]" required>
                        <option value="">Selecione um Produto...</option>
                        <?= $opcoes_produtos ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="quantidades[]" placeholder="Quantidade" min="1" required>
                </div>
            `;
            
            container.appendChild(novaLinha);
        }
    </script>
</body>
</html>