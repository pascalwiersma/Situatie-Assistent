<?php

session_start();

$title = 'Admin categorieen';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}

?>

<div class="container mx-auto mt-8 p-5">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Categorieen</h1>

        <a href="/admin/categorie-toevoegen.php" class="bg-primary text-white px-4 py-2 rounded">Nieuwe categorie</a>
    </div>

    <table class="table-auto w-full text-left whitespace-no-wrap mt-8">
        <thead class="bg-primary text-white">
            <tr>
                <th class="px-4 py-2">Naam</th>
                <th class="px-4 py-2">Afdeling</th>
                <th class="px-4 py-2">Acties</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            // Get the situations from database sql
            $sql = "SELECT * FROM `dialog_panels`";
            $categories = $db->select($sql);
            foreach ($categories as $categorie) :
                // Get afdeling from database sql
                $sql = "SELECT * FROM `departments` WHERE `uuid` = '$categorie[department]'";
                $department = $db->select($sql);
                $categorie['department'] = $department[0]['name'];

                ?>
                <tr class="hover:bg-gray-100">
                    <td class=" border px-4 py-3"><?= $categorie['name'] ?></td>
                    <td class="border px-4 py-3"><?= $categorie['department'] ?></td>
                    <td class="border px-4 py-3">
                        <a href="/admin/categorie-aanpassen.php?uuid=<?= $categorie['uuid'] ?>" class="bg-primary text-white px-4 py-2 rounded">Bewerken</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>


<?php require_once '../includes/footer.php' ?>
