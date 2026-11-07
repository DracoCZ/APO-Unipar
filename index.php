<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Gestor Logístico</title>
    <!-- Importação do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #ffffff; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* NAVBAR PADRONIZADA APENAS COM INICIO */
        .navbar-custom { background-color: #3b3f45; }
        .navbar-custom .nav-link { color: #a9a9a9; padding: 8px 16px; margin: 0 4px; }
        .navbar-custom .nav-link:hover { color: #ffffff; }
        .navbar-custom .nav-link.active { color: #ffffff; font-weight: 500; background-color: #555960; border-radius: 4px; }
        
        /* Estilização dos Cards */
        .card-custom {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }
        .card-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            color: inherit;
        }
        .img-card-left {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            min-height: 140px;
        }
        .card-title-custom {
            font-weight: 700;
            color: #212529;
            font-size: 1.1rem;
        }
        .card-text-custom {
            color: #6c757d;
            font-size: 0.85rem;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <!-- BARRA DE NAVEGAÇÃO APENAS COM O INICIO -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3 mb-4">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container mt-4 mb-5" style="max-width: 950px;">
        <h1 class="text-center mb-5" style="font-weight: 800; font-size: 2.5rem;">Gestor Logístico - APO/Unipar</h1>

        <!-- Grelha de 6 Cards (3x2) -->
        <div class="row g-4">
            
            <!-- Linha 1 - Card: Registrar Produtos -->
            <div class="col-md-6">
                <a href="cadastro_produto.php" class="card card-custom">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=400&q=80" class="img-card-left" alt="Produtos">
                        </div>
                        <div class="col-8">
                            <div class="card-body p-3">
                                <h5 class="card-title-custom">Registrar Produtos</h5>
                                <p class="card-text-custom">Cadastre os produtos e mercadorias que serão transportados. Insira detalhes como peso, dimensões, categoria e valores.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Linha 1 - Card: Registrar Endereços -->
            <div class="col-md-6">
                <a href="cadastro_endereco.php" class="card card-custom">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=400&q=80" class="img-card-left" alt="Endereços">
                        </div>
                        <div class="col-8">
                            <div class="card-body p-3">
                                <h5 class="card-title-custom">Registrar Endereços</h5>
                                <p class="card-text-custom">Cadastre e salve seus pontos de coleta e entrega frequentes. Mantenha um histórico de endereços de parceiros, clientes e filiais para agilizar a criação de novas rotas.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Linha 2 - Card: Registrar Transportadoras -->
            <div class="col-md-6">
                <a href="cadastro_transportadora.php" class="card card-custom">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=400&q=80" class="img-card-left" alt="Transportadoras">
                        </div>
                        <div class="col-8">
                            <div class="card-body p-3">
                                <h5 class="card-title-custom">Registrar Transportadoras</h5>
                                <p class="card-text-custom">Cadastre sua empresa de transporte para expandir seus negócios. Insira os dados corporativos, frota e documentação para começar a ofertar e gerenciar fretes na plataforma.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Linha 2 - Card: Criar Novo Frete -->
            <div class="col-md-6">
                <a href="gerar_frete.php" class="card card-custom">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1519003722824-194d4455a60c?auto=format&fit=crop&w=400&q=80" class="img-card-left" alt="Fretes">
                        </div>
                        <div class="col-8">
                            <div class="card-body p-3">
                                <h5 class="card-title-custom">Criar Novo Frete</h5>
                                <p class="card-text-custom">Cadastre rapidamente um novo pedido de transporte, informe os dados da carga, a rota desejada e conecte-se com motoristas disponíveis na plataforma.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Linha 3 - Card: Ver Relatórios -->
            <div class="col-md-6">
                <a href="relatorio.php" class="card card-custom">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=400&q=80" class="img-card-left" alt="Ver Relatórios">
                        </div>
                        <div class="col-8">
                            <div class="card-body p-3">
                                <h5 class="card-title-custom">Ver Relatórios</h5>
                                <p class="card-text-custom">Acompanhe o desempenho de suas viagens, custos, faturamentos e o histórico de entregas. Acesse dados detalhados para otimizar sua operação e tomar decisões estratégicas.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Linha 3 - Card: Edite Informações -->
            <div class="col-md-6">
                <a href="editar_geral.php" class="card card-custom">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=400&q=80" class="img-card-left" alt="Edite Informações">
                        </div>
                        <div class="col-8">
                            <div class="card-body p-3">
                                <h5 class="card-title-custom">Edite Informações</h5>
                                <p class="card-text-custom">Atualize e edite facilmente as informações do seu frete a qualquer momento. Modifique os dados de produto, endereços, e transportadora.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div> <!-- Fim da Grelha -->
    </div>

    <!-- JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>