<?php
include 'conexao.php';

if (isset($_GET['tabela']) && isset($_GET['id'])) {
    $tabela = $_GET['tabela'];
    $id = intval($_GET['id']);

    if ($tabela === 'fretes') {
        // Apaga primeiro os vínculos dos produtos do frete
        $conn->query("DELETE FROM frete_produtos WHERE frete_id = $id");
        // Apaga o frete
        $conn->query("DELETE FROM fretes WHERE id = $id");
        header("Location: relatorio.php");
        exit();
    }
}
?>