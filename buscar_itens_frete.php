<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $frete_id = intval($_GET['id']);

    // Busca todos os produtos do frete selecionado
    $sql = "SELECT p.nome, fp.quantidade, p.valor, (fp.quantidade * p.valor) AS subtotal
            FROM frete_produtos fp
            INNER JOIN produtos p ON fp.produto_id = p.id
            WHERE fp.frete_id = $frete_id";

    $res = $conn->query($sql);
    $total_geral = 0;

    if ($res && $res->num_rows > 0) {
        echo '<table class="table table-bordered align-middle mb-0">';
        echo '<thead class="table-light"><tr><th>Produto</th><th>Qtd</th><th>Valor Un.</th><th>Subtotal</th></tr></thead>';
        echo '<tbody>';
        while ($row = $res->fetch_assoc()) {
            $total_geral += $row['subtotal'];
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['nome']) . '</td>';
            echo '<td>' . $row['quantidade'] . '</td>';
            echo '<td>R$ ' . number_format($row['valor'], 2, ',', '.') . '</td>';
            echo '<td class="fw-bold">R$ ' . number_format($row['subtotal'], 2, ',', '.') . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '<tfoot class="table-group-divider"><tr><th colspan="3" class="text-end">Total dos Itens:</th><th class="text-success fw-bold">R$ ' . number_format($total_geral, 2, ',', '.') . '</th></tr></tfoot>';
        echo '</table>';
    } else {
        echo '<div class="alert alert-info mb-0 text-center">Nenhum produto associado a este frete.</div>';
    }
}
?>