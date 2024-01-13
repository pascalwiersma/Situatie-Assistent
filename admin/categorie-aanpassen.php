<?php

session_start();

$title = 'Admin categorie aanpassen';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}

$categorie_uuid = $_GET['uuid'];

// Get the categorie from database sql
$sql = "SELECT * FROM `dialog_panels` WHERE `uuid` =  ?";
$categorie = $db->select($sql, [$categorie_uuid]);
$categorie = $categorie[0];

if (!$categorie) {
    header('Location: /admin/categorieen.php');
    exit;
}

$naam = $categorie['name'];
$department = $categorie['department'];

if (isset($_POST['opslaan'])) {
    $name = trim($_POST['name']);
    $department = trim($_POST['department']);

    if (empty($name) || empty($department)) {
        $empty = true;
    } else {
        $sql = "UPDATE `dialog_panels` SET `name` = ?, `department` = ? WHERE `uuid` = ?";
        $db->update($sql, [$name, $department, $categorie_uuid]);

        $success = true;

        header("refresh:1;url=/admin/categorieen.php");
    }
}

?>

<div class="container mx-auto mt-8 p-5">

    <div class="mt-8">
        <form method="post">
            <?php if (isset($success)) : ?>
                <div class="bg-green-100 border px-4 py-3 my-5 rounded relative border-green-500" role="alert">
                    <strong class="font-bold">Gelukt!</strong>
                    <span class="block sm:inline">De categorie is aangepast.</span>
                </div>
            <?php endif; ?>
            <?php if (isset($empty)) : ?>
                <!-- error -->
                <div class="bg-red-100 border px-4 py-3 my-5 rounded relative border-red-500" role="alert">
                    <strong class="font-bold">Oeps!</strong>
                    <span class="block sm:inline">Vul alle velden in</span>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Naam
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3
                text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>"
                 id="name" name="name" type="text" placeholder="Naam" value="<?= $naam ?>">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
                    Afdeling
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3
                text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>"
                 id="department" name="department">
                    <?php
                    // Get the departments from database sql
                    $sql = "SELECT * FROM `departments`";
                    $departments = $db->select($sql);
                    foreach ($departments as $department) :
                        ?>
                        <option value="<?= $department['uuid'] ?>" <?= $department['uuid'] == $categorie['department'] ? 'selected' : '' ?>><?= $department['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <div class="mt-8">
                    <button type="submit" name="opslaan" class="bg-primary text-white px-4 py-2 rounded">Opslaan</button>
                </div>

                <div class="mt-4">
                    <a href="/admin/situaties.php" class="bg-gray-500 text-white px-4 py-2 rounded">Annuleren</a>
                </div>

            </div>

        </form>
    </div>

</div>


<?php require_once '../includes/footer.php' ?>
