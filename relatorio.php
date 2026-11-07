<?php
include 'conexao.php';

$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

$filtro_sql = "";
if (!empty($data_inicio) && !empty($data_fim)) {
    $filtro_sql = " WHERE f.data_frete BETWEEN '" . $data_inicio . "' AND '" . $data_fim . "'";
}

// QUERY ATUALIZADA COM ORIGEM, DESTINO, TRANSPORTADORA E VALOR (custo_total)
$sql = "SELECT f.id, f.data_frete, f.custo_total, t.nome_empresa, 
               e_origem.rua as rua_origem, e_origem.cidade as cidade_origem,
               e_destino.rua as rua_destino, e_destino.cidade as cidade_destino
        FROM fretes f 
        LEFT JOIN transportadoras t ON f.transportadora_id = t.id 
        LEFT JOIN enderecos e_origem ON f.origem_id = e_origem.id
        LEFT JOIN enderecos e_destino ON f.destino_id = e_destino.id 
        " . $filtro_sql . " ORDER BY f.id DESC";

$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Gestor Logístico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .navbar-custom { background-color: #3b3f45; }
        .navbar-custom .nav-link { color: #a9a9a9; padding: 8px 16px; margin: 0 4px; }
        .navbar-custom .nav-link:hover { color: #ffffff; }
        .navbar-custom .nav-link.active { color: #ffffff; font-weight: 500; background-color: #555960; border-radius: 4px; }
        
        @media print {
            .no-print { display: none !important; }
            body { background-color: #ffffff; }
            .shadow-sm { box-shadow: none !important; }
            .border { border: none !important; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3 mb-4 no-print">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerar_frete.php">Frete</a></li>
                    <li class="nav-item"><a class="nav-link active" href="relatorio.php">Relatorios</a></li>
                    <li class="nav-item"><a class="nav-link" href="editar_geral.php">Central de Edição</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <h2 class="text-center mb-4 fw-bold">Relatório de Fretes Gerados</h2>

        <div class="card p-4 mb-4 no-print shadow-sm border-0 bg-white rounded mx-auto" style="max-width: 900px;">
            <form method="GET" action="relatorio.php" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">Data Início</label>
                    <input type="date" class="form-control" name="data_inicio" value="<?= $data_inicio ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">Data Fim</label>
                    <input type="date" class="form-control" name="data_fim" value="<?= $data_fim ?>" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">🔍 Filtrar Relatório</button>
                </div>
            </form>
        </div>

        <div class="table-responsive shadow-sm bg-white p-3 rounded border-0">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nº Frete</th>
                        <th>Data</th>
                        <th>Transportadora</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Valor (R$)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($resultado) && $resultado !== false && $resultado->num_rows > 0) {
                        while($row = $resultado->fetch_assoc()) {
                            $data_formatada = isset($row['data_frete']) ? date("d/m/Y", strtotime($row['data_frete'])) : '-';
                            $nome_transp = isset($row['nome_empresa']) ? $row['nome_empresa'] : 'Sem Registro';
                            
                            $origem_completa = isset($row['rua_origem']) ? $row['rua_origem'] . " - " . $row['cidade_origem'] : 'Sem Registro';
                            $destino_completo = isset($row['rua_destino']) ? $row['rua_destino'] . " - " . $row['cidade_destino'] : 'Sem Registro';
                            
                            $valor_formatado = isset($row['custo_total']) ? "R$ " . number_format($row['custo_total'], 2, ',', '.') : 'R$ 0,00';
                            
                            echo "<tr>";
                            echo "<td class='fw-bold'>#00" . $row['id'] . "</td>";
                            echo "<td>" . $data_formatada . "</td>";
                            echo "<td>" . $nome_transp . "</td>";
                            echo "<td>" . $origem_completa . "</td>";
                            echo "<td>" . $destino_completo . "</td>";
                            echo "<td class='fw-bold text-success'>" . $valor_formatado . "</td>";
                            echo "<td><span class='badge bg-success'>Concluído</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted py-4'>Nenhum frete encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4 no-print">
            <button onclick="window.print()" class="btn btn-danger btn-lg fw-bold shadow">
                🖨️ Imprimir em PDF
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>