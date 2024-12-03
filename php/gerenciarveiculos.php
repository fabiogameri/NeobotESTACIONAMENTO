<?php
// Conexão com o banco de dados SQLite
$db = new SQLite3('C:\xampp\htdocs\Projeto Estacionamento\sqlite3\veiculos.db');

// Função para excluir um veículo
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $db->exec("DELETE FROM veiculos WHERE id = $deleteId");
    header("Location: gerenciarveiculos.php");
    exit();
}

// Função para atualizar as informações de um veículo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $updateId = $_POST['update_id'];
    $marca = $_POST['marca'];
    $cor = $_POST['cor'];
    $ano = $_POST['ano'];
    $modelo = $_POST['modelo'];

    $stmt = $db->prepare("UPDATE veiculos SET marca = :marca, cor = :cor, ano = :ano, modelo = :modelo WHERE id = :id");
    $stmt->bindValue(':marca', $marca, SQLITE3_TEXT);
    $stmt->bindValue(':cor', $cor, SQLITE3_TEXT);
    $stmt->bindValue(':ano', $ano, SQLITE3_INTEGER);
    $stmt->bindValue(':modelo', $modelo, SQLITE3_TEXT);
    $stmt->bindValue(':id', $updateId, SQLITE3_INTEGER);
    $stmt->execute();
    
    header("Location: gerenciarveiculos.php");
    exit();
}

// Consulta para obter todos os veículos
$result = $db->query("SELECT * FROM veiculos");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Veículos</title>
    <link rel="stylesheet" href="../css/style_gerenciar.css">
    <script>
        // Função para exibir ou ocultar o formulário de edição
        function toggleEditForm(id) {
            const editForm = document.getElementById('edit-form-' + id);
            editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>

<h1>Gerenciar Veículos</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Pessoa</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Ano</th>
        <th>Cor</th>
        <th>Dia</th>
        <th>Mês</th>
        <th>Ações</th>
    </tr>

    <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['pessoa']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <td><?php echo $row['modelo']; ?></td>
        <td><?php echo $row['ano']; ?></td>
        <td><?php echo $row['cor']; ?></td>
        <td><?php echo $row['dia']; ?></td>
        <td><?php echo $row['mes']; ?></td>
        <td class="actions">
            <!-- Botão de edição -->
            <button onclick="toggleEditForm(<?php echo $row['id']; ?>)" class="btn-editar">Editar</button>

            <!-- Formulário de edição (inicialmente oculto) -->
            <form method="POST" id="edit-form-<?php echo $row['id']; ?>" style="display: none; margin-top: 5px;">
                <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>">
                <!-- Campo Marca: Apenas letras, números e espaços -->
                <input type="text" name="marca" value="<?php echo $row['marca']; ?>" placeholder="Marca" required 
                    pattern="[A-Za-z0-9 ]+" title="Somente letras, números e espaços.">
                <!-- Campo Modelo: Apenas letras, números e espaços -->
                <input type="text" name="modelo" value="<?php echo $row['modelo']; ?>" placeholder="Modelo" required 
                    pattern="[A-Za-z0-9 ]+" title="Somente letras, números e espaços.">
                <!-- Campo Ano: Apenas números, limite de 4 dígitos -->
                <input type="number" name="ano" value="<?php echo $row['ano']; ?>" placeholder="Ano" required 
                    pattern="\d{4}" title="Digite um ano válido de 4 dígitos." min="1800" max="2099">
                 <!-- Campo Cor: Apenas letras e espaços -->
                <input type="text" name="cor" value="<?php echo $row['cor']; ?>" placeholder="Cor" required 
                    pattern="[A-Za-z ]+" title="Somente letras e espaços."><br><br>
                <button type="submit" class="btn-salvar" onclick="toggleDeleteButton(<?php echo $row['id']; ?>)">Salvar</button>
            </form>

            <!-- Botão para excluir com mais destaque -->
            <a href="gerenciarveiculos.php?delete_id=<?php echo $row['id']; ?>" id="delete-<?php echo $row['id']; ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este veículo?')">Excluir</a>
        </td>
    </tr>
<?php endwhile; ?>
</table>

<script>
    function toggleEditForm(id) {
        var form = document.getElementById('edit-form-' + id);
        var deleteButton = document.getElementById('delete-' + id);
        if (form.style.display === 'none') {
            // Limpar os campos do formulário 
            form.reset();
            form.style.display = 'block';
            deleteButton.style.display = 'none';  // Ocultar botão Excluir
        } else {
            form.style.display = 'none';
            deleteButton.style.display = 'inline';  // Mostrar botão Excluir
        }
    }

    function toggleDeleteButton(id) {
        var deleteButton = document.getElementById('delete-' + id);
        deleteButton.style.display = 'inline';  // Mostrar botão Excluir
    }
</script>

<!-- Botão para voltar ao menu principal -->
<a href="../index.html" class="btn-voltar">Voltar ao Menu</a>
</body>
</html>
