<?php
require 'conexaodb.php';

$db = new SQLite3('C:\xampp\htdocs\Projeto Estacionamento\sqlite3\veiculos.db');
$sql = "SELECT id, pessoa, marca, modelo, ano, cor, dia, mes, pago, data_renovacao FROM veiculos";
$result = $db->query($sql);

function obterNomeMes($mes) {
    $meses = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
    ];
    return $meses[$mes];
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta Tag para o Viewport -->
    <title>Lista de Veículos</title>
    <link rel="stylesheet" href="../css/style_listagem.css">
</head>
<body>
    <div class="table-container">
        <h1>Veículos Cadastrados</h1>
        <div class="veiculos-list">
            <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): 
                // Calcular a data de vencimento
                $dataAtual = new DateTime();
                $dataVencimento = new DateTime($row['ano'] . '-' . $row['mes'] . '-' . $row['dia']);
                $dataRenovacao = $row['data_renovacao'] ? new DateTime($row['data_renovacao']) : null;
                $intervalo = $dataAtual->diff($dataVencimento);
                $diasParaVencimento = (int)$intervalo->format('%r%a');

                // Determinar a cor de fundo com base no status de pagamento e data de renovação
                $classeVencimento = '';

                if ($row['pago'] == 0) {
                    // Se a data de renovação for NULL, tratar como vencido
                    if ($dataRenovacao === null) {
                        $classeVencimento = 'vencido';  // Não foi renovado, vencido
                    } elseif ($diasParaVencimento <= 0) {
                        // Caso de pagamento pendente e data vencida
                        $classeVencimento = 'vencido';
                    } elseif ($diasParaVencimento <= 5) {
                        // Caso de pagamento pendente e próximo ao vencimento
                        $classeVencimento = 'proximo-vencimento';
                    } else {
                        // Verificar se a renovação é válida e no futuro
                        if ($dataRenovacao && $dataRenovacao > $dataAtual) {
                            // Manter sem alteração pois o vencimento ainda está no futuro
                            $classeVencimento = '';
                        } elseif ($dataAtual > (clone $dataRenovacao)->modify('+1 month')) {
                            // Caso de pagamento pendente e renovação vencida após o limite de um mês
                            $classeVencimento = 'vencido';
                        }
                    }
                }
                ?>

                <div class="veiculo-item <?php echo $classeVencimento; ?>">
                    <h2><?php echo htmlspecialchars($row['pessoa']); ?></h2>
                    <p><strong>Marca:</strong> <?php echo htmlspecialchars($row['marca']); ?></p>
                    <p><strong>Modelo:</strong> <?php echo htmlspecialchars($row['modelo']); ?></p>
                    <p><strong>Ano:</strong> <?php echo htmlspecialchars($row['ano']); ?></p>
                    <p><strong>Cor:</strong> <?php echo htmlspecialchars($row['cor']); ?></p>
                    <p><strong>Dia:</strong> <?php echo htmlspecialchars($row['dia']); ?></p>
                    <p><strong>Mês:</strong> <?php echo obterNomeMes($row['mes']); ?></p>
                    <p><strong>Pagamento:</strong> <?php echo $row['pago'] ? 'Pago' : 'Não Pago'; ?></p>
                    <p><strong>Data de Renovação:</strong> <?php echo htmlspecialchars($row['data_renovacao']); ?></p>
                    <?php if ($row['pago'] == 0): ?>
                        <form method="post" action="renovar.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Renovar Mensalidade</button>
                        </form>
                    <?php else: ?>
                        <form method="post" action="cancelar_renovacao.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Cancelar Renovação</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Rodapé com o botão centralizado -->
    <footer>
        <button class="voltar" onclick="window.location.href='../index.html'">Voltar ao Menu</button>
    </footer>
</body>
</body>
</html>

<?php
$db->close();
?>
