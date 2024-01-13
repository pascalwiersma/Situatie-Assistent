<?php

session_start();

$title = 'Admin situaties';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}

?>

<div class="container mx-auto mt-8 p-5">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Situaties</h1>

        <a href="/admin/situatie-toevoegen.php" class="bg-primary text-white px-4 py-2 rounded">Nieuwe situatie</a>
    </div>

    <table class="table-auto w-full text-left whitespace-no-wrap mt-8">
        <thead class="bg-primary text-white">
            <tr>
                <th class="px-4 py-2">Naam</th>
                <th class="px-4 py-2">Afdeling</th>
                <th class="px-4 py-2">Panel</th>
                <th class="px-4 py-2">Acties</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            // Get the situations from database sql
            $sql = "SELECT * FROM `dialogs` WHERE `is_root` = 1";
            $situations = $db->select($sql);
            foreach ($situations as $situation) :
                // Get afdeling from database sql
                $sql = "SELECT * FROM `departments` WHERE `uuid` = '$situation[department]'";
                $department = $db->select($sql);
                $situation['department'] = $department[0]['name'];

                // Get dialog panel from database sql
                $sql = "SELECT * FROM `dialog_panels` WHERE `uuid` = '$situation[panel]'";
                $dialog_panel = $db->select($sql);
                $situation['panel'] = $dialog_panel[0]['name'];

                ?>
                <tr class="hover:bg-gray-100">
                    <td class=" border px-4 py-3"><?= $situation['title'] ?></td>
                    <td class="border px-4 py-3"><?= $situation['department'] ?></td>
                    <td class="border px-4 py-3"><?= $situation['panel'] ?></td>
                    <td class="border px-4 py-3">
                        <a href="/admin/situatie-aanpassen.php?uuid=<?= $situation['uuid'] ?>" class="bg-primary text-white px-4 py-2 rounded">Bewerken</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>


<?php require_once '../includes/footer.php' ?>
