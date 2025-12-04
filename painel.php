<?php
session_start();
// O usuário não forneceu 'verifica_login.php', mas a lógica de inclusão foi mantida para evitar quebrar o sistema.
include('verifica_login.php'); 

$email_usuario = htmlspecialchars($_SESSION['email']); 
$username = explode('@', $email_usuario)[0]; // LÓGICA MANTIDA
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Sistema de Gerenciamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* VARIÁVEIS DE CORES MODERNAS */
        :root {
            --primary-color: #3f51b5; /* Deep Indigo - Para menus, textos primários */
            --primary-dark: #303f9f;
            --accent-color: #ff9800; /* Amber/Laranja - Para botões de ação e destaque */
            --success-color: #4CAF50; /* Verde para sucesso */
            --background-color: #f4f6f9; /* Fundo Leve */
            --sidebar-bg: #263238; /* Cinza Escuro para Sidebar */
            --sidebar-text: #eceff1;
            --header-bg: #ffffff;
            --card-bg: #ffffff;
            --shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s;
        }

        /* 1. TOP NAVBAR (HEADER) */
        .navbar-top {
            background-color: var(--header-bg);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: calc(100% - var(--sidebar-width));
            left: var(--sidebar-width);
            top: 0;
            z-index: 1030;
            height: 70px;
            display: flex;
            align-items: center;
        }

        /* 2. SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1050;
            overflow-y: auto;
            padding-top: 20px;
        }
        
        .sidebar-header {
            text-align: center;
            padding: 15px 0;
            margin-bottom: 20px;
        }
        .sidebar-header h4 {
            color: var(--success-color); /* Destaque no nome do sistema */
            font-weight: 700;
        }

        .nav-link-sidebar {
            color: var(--sidebar-text);
            padding: 15px 20px;
            border-radius: 8px;
            margin: 5px 10px;
            transition: background-color 0.2s, color 0.2s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .nav-link-sidebar:hover, .nav-link-sidebar:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .nav-link-sidebar.active {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
        }
        .nav-link-logout {
            color: #ff5252;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        .nav-link-logout:hover {
            color: #ff1744;
        }

        /* 3. MAIN CONTENT */
        .main-content {
            padding: 30px;
            margin-top: 70px;
            transition: margin-left 0.3s;
        }
        
        /* 4. CARDS DE AÇÃO (Refinado) */
        .modern-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            background-color: var(--card-bg);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .modern-card-dashboard {
            border-left: 5px solid;
        }
        /* Borda de Destaque Laranja (para Estatísticas) */
        .modern-card-dashboard.border-accent {
            border-color: var(--accent-color) !important;
        }
        .modern-card-dashboard.border-success {
            border-color: var(--success-color) !important;
        }

        .modern-card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .card-title {
            font-size: 1.3rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 6px;
        }
        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            border-radius: 6px;
        }
        
        /* NOVO ESTILO PARA O BOTÃO LARANJA (VER ESTATÍSTICAS) */
        .btn-card-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white; /* Cor da escrita branca conforme solicitado */
            border-radius: 6px;
            transition: background-color 0.2s;
        }
        .btn-card-accent:hover {
            background-color: #e68900; /* Um pouco mais escuro ao passar o mouse */
            border-color: #e68900;
            color: white;
        }
    </style>
    </head>
<body>
    
    <nav class="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-mortarboard-fill me-2"></i> Manoel Mano</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link-sidebar active" href="painel.php">
                    <i class="bi bi-grid-fill me-3"></i> Dashboard Principal
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link-sidebar" href="estatisticas.php">
                    <i class="bi bi-bar-chart-line-fill me-3"></i> Relatórios Analíticos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link-sidebar" href="primeiros100.php">
                    <i class="bi bi-list-ol me-3"></i> 100 Primeiros Registros
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link-sidebar" href="novo_formulario_aluno.php">
                    <i class="bi bi-person-plus-fill me-3"></i> Cadastrar Novo Aluno
                </a>
            </li>
        </ul>
        
        <hr class="mx-3 my-4" style="border-color: #4e5e6e;">

        <ul class="nav flex-column">
            <li class="nav-item p-3">
                <a class="nav-link-logout" href="logout.php">
                    <i class="bi bi-box-arrow-left me-2"></i> Sair do Sistema
                </a>
            </li>
        </ul>
    </nav>
    
    <nav class="navbar-top px-4">
        <div class="ms-auto">
             <span class="text-muted me-3">Olá,</span>
             <span class="fw-bold text-dark me-2" style="color: var(--primary-color) !important;"><?php echo htmlspecialchars($username); ?></span>
             <i class="bi bi-person-circle fs-5" style="color: var(--primary-color);"></i>
        </div>
    </nav>

    <div class="main-content">
        <h1 class="mb-4 fw-light" style="color: var(--primary-dark);">Painel Principal</h1>
        <p class="lead mb-5 text-muted">Acesse as principais funcionalidades do sistema.</p>

        <div class="row">
            
            <div class="col-md-6 mb-4">
                <a href="estatisticas.php" class="text-decoration-none">
                    <div class="card modern-card modern-card-dashboard text-center p-4 border-accent"> <i class="bi bi-bar-chart-line-fill card-icon" style="color: var(--accent-color);"></i>
                        <h5 class="card-title fw-bold" style="color: var(--accent-color);">Relatórios Analíticos</h5>
                        <p class="card-text text-muted">Visualize dados e gráficos sobre o sistema e alunos.</p>
                        <span class="btn btn-card-accent mt-3">Ver Estatísticas <i class="bi bi-arrow-right"></i></span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-4">
                <a href="novo_formulario_aluno.php" class="text-decoration-none">
                    <div class="card modern-card modern-card-dashboard text-center p-4 border-success">
                        <i class="bi bi-person-plus-fill card-icon" style="color: var(--success-color);"></i>
                        <h5 class="card-title fw-bold" style="color: var(--success-color);">Cadastrar Novo Aluno</h5>
                        <p class="card-text text-muted">Adicione novos registros de alunos ao banco de dados.</p>
                        <span class="btn btn-success mt-3">Iniciar Cadastro <i class="bi bi-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="alert alert-info text-center modern-card border-0">
                    <i class="bi bi-info-circle me-2"></i> Utilize o menu lateral para navegar entre as seções.
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>