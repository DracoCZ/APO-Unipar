<?php
include 'conexao.php';

// Processa a exclusão se a ação de deletar for acionada
if (isset($_GET['acao']) && $_GET['acao'] === 'deletar' && isset($_GET['id'])) {
    $id_deletar = intval($_GET['id']);
    
    // Apaga primeiro as referências dos produtos associados a este frete
    $conn->query("DELETE FROM frete_produtos WHERE frete_id = $id_deletar");
    
    // Apaga o registro do frete
    $conn->query("DELETE FROM fretes WHERE id = $id_deletar");
    
    header("Location: relatorio.php");
    exit();
}

$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

$filtro_sql = "";
if (!empty($data_inicio) && !empty($data_fim)) {
    $filtro_sql = " WHERE f.data_frete BETWEEN '" . $data_inicio . "' AND '" . $data_fim . "'";
}

// QUERY COM ORIGEM, DESTINO, TRANSPORTADORA E VALOR (custo_total)
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
                    <input type="date" class="form-control" name="data_inicio" value="<?= $data_inicio ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">Data Fim</label>
                    <input type="date" class="form-control" name="data_fim" value="<?= $data_fim ?>">
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
                        <th class="text-center">Ações</th>
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
                            echo "<td class='text-center'>
                                    <button class='btn btn-sm btn-outline-primary no-print me-1' onclick='carregarItens(" . $row['id'] . ")'>
                                        📦 Ver Itens
                                    </button>
                                    <a href='relatorio.php?acao=deletar&id=" . $row['id'] . "' class='btn btn-sm btn-outline-danger no-print me-1' onclick=\"return confirm('Tem certeza que deseja excluir o Frete #00" . $row['id'] . "?');\">
                                        🗑️ Eliminar
                                    </a>
                                    <span class='badge bg-success'>Concluído</span>
                                  </td>";
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

    <!-- MODAL BOOTSTRAP PARA DETALHES DOS ITENS -->
    <div class="modal fade no-print" id="modalItens" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="modalTitulo">Produtos do Frete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modalConteudo">
                    <div class="text-center text-muted py-3">Carregando itens...</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function carregarItens(freteId) {
            document.getElementById('modalTitulo').innerText = 'Produtos do Frete #00' + freteId;
            document.getElementById('modalConteudo').innerHTML = '<div class="text-center text-muted py-3">Carregando itens...</div>';
            
            var modal = new bootstrap.Modal(document.getElementById('modalItens'));
            modal.show();

            fetch('buscar_itens_frete.php?id=' + freteId)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('modalConteudo').innerHTML = html;
                })
                .catch(err => {
                    document.getElementById('modalConteudo').innerHTML = '<div class="alert alert-danger mb-0">Erro ao carregar os itens.</div>';
                });
        }
    </script>
</body>
</html>