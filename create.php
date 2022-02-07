<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $birth = isset($_POST['birth']) ? $_POST['birth'] : '';
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $rg = isset($_POST['rg']) ? $_POST['rg'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO lista VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $surname, $birth, $cpf, $rg]);
    // Output message
    $msg = 'Created Successfully!';
    header("Location: index.php");
}
?>

<?=template_header('Criar')?>

<div class="content update">
	<h2>Criar Contato</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Nome</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id" disabled="">
        <input type="text" name="name" placeholder="Helder" id="name">
        <label for="surname">Sobrenome</label>
        <label for="birth">Nascimento</label>
        <input type="text" name="surname" placeholder="Thury" id="email">
        <input type="date" name="birth" placeholder="" id="phone" value="<?=date('Y-m-d')?>">
        <label for="cpf">CPF</label>
        <label for="rg">RG</label>
        <input type="number" name="cpf" placeholder="Somente números" id="title">
        <input type="number" name="rg"  placeholder="Somente números" id="created">
        <input type="submit" value="Salvar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>