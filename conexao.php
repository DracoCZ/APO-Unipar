<?php
$servidor = "localhost";
$utilizador = "root";
$senha = ""; // No XAMPP, a palavra-passe do root é vazia por predefinição
$banco = "logistica_unipar";

// Criar a ligação
$conn = new mysqli($servidor, $utilizador, $senha, $banco);

// Verificar a ligação
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}
//echo "Ligação à base de dados logistica_unipar bem-sucedida!";
?>