<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        // $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $id = $_GET['id'];
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
        $birth = isset($_POST['birth']) ? $_POST['birth'] : '';
        $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
        $rg = isset($_POST['rg']) ? $_POST['rg'] : '';
        // Update the record
        $stm = "UPDATE lista SET id = ?, name = ?, surname = ?, birth = ?, cpf = ?, rg = ? WHERE id = ?";
        $stmt = $pdo->prepare($stm);
        $stmt->execute([$id, $name, $surname, $birth, $cpf, $rg, $_GET['id'] ]);
        $msg = 'Atualizado!' . $stm;
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM lista WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contato não existe!');
    }
} else {
    exit('ID não foi citada!');
}
?>

<?=template_header('CLIENTES')?>

<div class="content update">
	<h2>Atualizar Contato da ID: <?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Nome</label>
        <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id" disabled="">
        <input type="text" name="name" placeholder="John Doe" value="<?=$contact['name']?>" id="name">
        <label for="email">Sobrenome</label>
        <label for="birth">Nascimento</label>
        <input type="text" name="surname" placeholder="johndoe@example.com" value="<?=$contact['surname']?>" id="surname">
        <input type="date" name="birth" value="<?=date('Y-m-d', strtotime($contact['birth']))?>" id="birth">
        <label for="cpf">CPF</label>
        <label for="rg">RG</label>
        <input type="text" name="cpf" placeholder="Employee" value="<?=$contact['cpf']?>" id="cpf">
        <input type="number" name="rg"  placeholder="Somente números" value="<?=$contact['rg']?>" id="rg">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>