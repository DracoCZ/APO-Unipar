<?php
include 'conexao.php';

$filtro_data = "";
// Consulta SQL base que junta as 3 tabelas necessárias
$sql = "SELECT f.data_frete, t.nome_empresa, 
               origem.cidade AS cidade_origem, origem.estado AS estado_origem,
               destino.cidade AS cidade_destino, destino.estado AS estado_destino,
               f.custo_total
        FROM fretes f
        JOIN transportadoras t ON f.transportadora_id = t.id
        JOIN enderecos origem ON f.origem_id = origem.id
        JOIN enderecos destino ON f.destino_id = destino.id";

// Se o utilizador pesquisou por uma data, adiciona o filtro WHERE
if (isset($_GET['data_filtro']) && !empty($_GET['data_filtro'])) {
    $filtro_data = $_GET['data_filtro'];
    $sql .= " WHERE f.data_frete = '$filtro_data'";
}

$sql .= " ORDER BY f.data_frete DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Fretes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-custom { background-color: #343a40; }
        .btn-custom { background-color: #5b58ff; color: white; border: none; }
        .btn-custom:hover { background-color: #4a47e6; color: white; }
        /* Esconde elementos indesejados na hora de imprimir/guardar PDF */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; }
            .container { box-shadow: none; max-width: 100%; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom no-print">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Gestor Logístico</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerar_frete.php">Fretes</a></li>
                    <li class="nav-item"><a class="nav-link active" href="relatorio.php">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 bg-white p-4 shadow-sm rounded">
        <h2 class="mb-4 fw-bold text-center">Relatório Diário de Fretes</h2>

        <!-- Formulário de Filtro de Data -->
        <form method="GET" action="relatorio.php" class="row g-3 mb-4 no-print">
            <div class="col-auto">
                <label for="data_filtro" class="visually-hidden">Filtrar por Data</label>
                <input type="date" class="form-control" id="data_filtro" name="data_filtro" value="<?= $filtro_data ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">Pesquisar</button>
                <a href="relatorio.php" class="btn btn-outline-danger">Limpar</a>
            </div>
        </form>

        <!-- Tabela de Resultados -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Data</th>
                        <th>Transportadora</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Custo Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows > 0): ?>
                        <?php while($linha = $resultado->fetch_assoc()): ?>
                            <tr>
                                <!-- Formata a data para o padrão dd/mm/aaaa -->
                                <td><?= date("d/m/Y", strtotime($linha['data_frete'])) ?></td>
                                <td><?= $linha['nome_empresa'] ?></td>
                                <td><?= $linha['cidade_origem'] . "/" . $linha['estado_origem'] ?></td>
                                <td><?= $linha['cidade_destino'] . "/" . $linha['estado_destino'] ?></td>
                                <td>R$ <?= number_format($linha['custo_total'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nenhum frete encontrado para esta data.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4 no-print">
            <button onclick="window.print()" class="btn btn-custom px-4 py-2">Descarregar Relatório</button>
        </div>
    </div>

</body>
</html>