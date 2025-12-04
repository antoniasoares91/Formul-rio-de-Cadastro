<?php
session_start();
include('conexao.php'); 
// --- 1. BUSCA DE TOTAIS --- (LÓGICA MANTIDA)
// a) Consulta para contagem total de usuários (tabela users)
$sql_count_users = "SELECT COUNT(*) AS total_usuarios FROM users";
$resultado_count_users = mysqli_query($conexao, $sql_count_users);
$total_usuarios_users = 0;
if ($resultado_count_users) {
    $row = mysqli_fetch_assoc($resultado_count_users);
    $total_usuarios_users = (int)$row['total_usuarios'];
}
// b) Consulta para contagem total de alunos (tabela alunos)
$sql_count_alunos = "SELECT COUNT(*) AS total_alunos FROM alunos";
$resultado_count_alunos = mysqli_query($conexao, $sql_count_alunos);
$total_usuarios_alunos = 0;
if ($resultado_count_alunos) {
    $row = mysqli_fetch_assoc($resultado_count_alunos);
    $total_usuarios_alunos = (int)$row['total_alunos'];
}
// c) Cálculo do Total Geral
$total_geral = $total_usuarios_users + $total_usuarios_alunos;


// --- 2. DADOS PARA GRÁFICOS DETALHADOS --- (LÓGICA MANTIDA)
// a) Consulta para contagem de alunos por Curso (para o 2º Gráfico)
$dados_cursos = [];
$sql_cursos = "SELECT curso, COUNT(*) AS total_curso FROM alunos GROUP BY curso";
$resultado_cursos = mysqli_query($conexao, $sql_cursos);
if ($resultado_cursos) {
    while($row = mysqli_fetch_assoc($resultado_cursos)) {
        $dados_cursos[] = "['" . $row['curso'] . "', " . $row['total_curso'] . "]";
    }
}
$dados_cursos_js = implode(",\n", $dados_cursos);

// b) Consulta para contagem de alunos por Tipo de Responsável (para o 3º Gráfico)
$dados_responsavel = [];
$sql_responsavel = "SELECT tipo_responsavel, COUNT(*) AS total_responsavel FROM alunos GROUP BY tipo_responsavel";
$resultado_responsavel = mysqli_query($conexao, $sql_responsavel);
if ($resultado_responsavel) {
    while($row = mysqli_fetch_assoc($resultado_responsavel)) {
        $dados_responsavel[] = "['" . $row['tipo_responsavel'] . "', " . $row['total_responsavel'] . "]";
    }
}
$dados_responsavel_js = implode(",\n", $dados_responsavel);

// c) Consulta para listar os últimos alunos cadastrados (para a Tabela)
$dados_tabela_alunos = [];
$sql_tabela_alunos = "SELECT nome_completo, curso, data_cadastro FROM alunos ORDER BY aluno_id DESC LIMIT 5"; 
$resultado_tabela_alunos = mysqli_query($conexao, $sql_tabela_alunos);
if ($resultado_tabela_alunos) {
    while($row = mysqli_fetch_assoc($resultado_tabela_alunos)) {
        $dados_tabela_alunos[] = $row;
    }
}

// Fecha a conexão
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios Analíticos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* VARIÁVEIS DE CORES MODERNAS */
        :root {
            --primary-color: #3f51b5; /* Deep Indigo - Para menus, textos primários */
            --primary-dark: #303f9f;
            --accent-color: #ff9800; /* Amber/Laranja - Para botões de ação e destaque (AJUSTE CONFORME SEU LOGO) */
            --success-color: #4CAF50; /* Verde para sucesso */
            --background-color: #f4f6f9; /* Fundo Leve */
            --card-bg: #ffffff;
            --shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--background-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .header-section {
            background-color: var(--primary-color);
            color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .stats-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            transition: transform 0.3s;
            overflow: hidden;
        }

        .stats-card-body {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats-card .icon-circle {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            padding: 15px;
            font-size: 1.5rem;
        }

        .text-total {
            font-size: 2.5rem;
            font-weight: bold;
            line-height: 1;
        }

        .card-chart {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            background-color: var(--card-bg);
            padding: 20px;
        }

        /* Adaptação das Cores de Fundo das Stats Card */
        .bg-card-primary { background-color: var(--primary-color) !important; color: white; }
        .bg-card-success { background-color: var(--success-color) !important; color: white; }
        .bg-card-accent { background-color: var(--accent-color) !important; color: white; }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-dark);
        }
    </style>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawAllCharts);

        function drawAllCharts() {
            drawDistributionChart();
            drawCourseChart();
            drawResponsibleChart();
        }

        // --- GRÁFICO 1: DISTRIBUIÇÃO GERAL (COLUNA) - CORES ATUALIZADAS ---
        function drawDistributionChart() {
            var data = google.visualization.arrayToDataTable([
                ['Tipo', 'Total', { role: 'style' }],
                ['Usuários (Sistema)', <?php echo $total_usuarios_users; ?>, '#3f51b5'], /* Nova cor: Deep Indigo */
                ['Alunos (Cadastrados)', <?php echo $total_usuarios_alunos; ?>, '#4CAF50'] /* Nova cor: Green */
            ]);

            var options = {
                title: 'Distribuição de Cadastros (Usuários vs Alunos)',
                backgroundColor: 'transparent',
                legend: { position: 'none' },
                chartArea: { width: '80%' },
                vAxis: { format: '0' },
                animation: { duration: 1000, startup: true }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('distribution_chart_div'));
            chart.draw(data, options);
        }

        // --- GRÁFICO 2: ALUNOS POR CURSO (PIZZA) - CORES ATUALIZADAS ---
        function drawCourseChart() {
            var data = google.visualization.arrayToDataTable([
                ['Curso', 'Total de Alunos'],
                <?php echo $dados_cursos_js; ?>
            ]);

            var options = {
                title: 'Alunos por Curso',
                is3D: true,
                backgroundColor: 'transparent',
                colors: ['#3f51b5', '#ff9800', '#03a9f4', '#4CAF50', '#ffc107'], /* Nova paleta */
                chartArea: { width: '90%', height: '85%' },
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.PieChart(document.getElementById('course_chart_div'));
            chart.draw(data, options);
        }

        // --- GRÁFICO 3: ALUNOS POR RESPONSÁVEL (PIZZA) - CORES ATUALIZADAS ---
        function drawResponsibleChart() {
            var data = google.visualization.arrayToDataTable([
                ['Tipo de Responsável', 'Total'],
                <?php echo $dados_responsavel_js; ?>
            ]);

            var options = {
                title: 'Distribuição por Tipo de Responsável',
                backgroundColor: 'transparent',
                colors: ['#03a9f4', '#ff9800', '#3f51b5', '#4CAF50', '#ff5252'], /* Nova paleta */
                chartArea: { width: '90%', height: '85%' },
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.PieChart(document.getElementById('responsible_chart_div'));
            chart.draw(data, options);
        }
    </script>
    </head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header-section">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 fw-light"><i class="bi bi-bar-chart-line-fill me-2"></i> Relatórios Analíticos</h2>
                        <a href="painel.php" class="btn btn-light shadow-sm"><i class="bi bi-arrow-left me-2"></i> Voltar ao Painel</a>
                    </div>
                    <p class="lead mt-2 mb-0">Visão geral e estatísticas detalhadas do sistema.</p>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            
            <div class="col-md-4">
                <div class="stats-card bg-card-primary text-white">
                    <div class="stats-card-body">
                        <div>
                            <div class="text-total"><?php echo $total_usuarios_users; ?></div>
                            <small class="text-uppercase fw-light">Usuários no Sistema</small>
                        </div>
                        <i class="bi bi-people-fill icon-circle" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stats-card bg-card-success text-white">
                    <div class="stats-card-body">
                        <div>
                            <div class="text-total"><?php echo $total_usuarios_alunos; ?></div>
                            <small class="text-uppercase fw-light">Alunos Cadastrados</small>
                        </div>
                        <i class="bi bi-mortarboard-fill icon-circle" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stats-card bg-card-accent text-white">
                    <div class="stats-card-body">
                        <div>
                            <div class="text-total"><?php echo $total_geral; ?></div>
                            <small class="text-uppercase fw-light">Total Geral de Cadastros</small>
                        </div>
                        <i class="bi bi-server icon-circle" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-12">
                <div class="card-chart">
                    <h5 class="fw-bold mb-3 text-primary">Análise da Base de Dados</h5>
                    <div id="distribution_chart_div" style="height: 350px;"></div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card-chart">
                    <h5 class="fw-bold mb-3 text-primary">Alunos por Curso</h5>
                    <div id="course_chart_div" style="height: 350px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-chart">
                    <h5 class="fw-bold mb-3 text-primary">Alunos por Responsável</h5>
                    <div id="responsible_chart_div" style="height: 350px;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-chart">
                    <h5 class="fw-bold mb-3 text-primary">Últimos Alunos Cadastrados</h5>
                    
                    <?php if (!empty($dados_tabela_alunos)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Nome Completo</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dados_tabela_alunos as $dado): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($dado['nome_completo']); ?></td>
                                            <td><span class="badge bg-primary"><?php echo htmlspecialchars($dado['curso']); ?></span></td>
                                            <td><?php echo date('d/m/Y', strtotime($dado['data_cadastro'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">Nenhum aluno encontrado para exibir.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>