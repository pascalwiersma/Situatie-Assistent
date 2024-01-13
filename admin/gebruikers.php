<?php

session_start();

$title = 'Admin gebruikers';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}
?>

<div class="container mx-auto mt-8 p-5">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Gebruikers</h1>

        <a href="/admin/gebruiker-toevoegen.php" class="bg-primary text-white px-4 py-2 rounded">Nieuwe gebruiker</a>
    </div>

    <table class="table-auto w-full text-left whitespace-no-wrap mt-8">
        <thead class="bg-primary text-white">
            <tr>
                <th class="px-4 py-2">Volledige naam</th>
                <th class="px-4 py-2">Bedrijf</th>
                <th class="px-4 py-2">Afdeling</th>
                <th class="px-4 py-2">isAdmin</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            // Get the users from database sql
            $sql = "SELECT * FROM `users`";
            $users = $db->select($sql);

            foreach ($users as $user) :
                ?>
                <tr>
                    <td class="border px-4 py-2"><?= $user['full_name'] ?></td>
                    <td class="border px-4 py-2"><?= $user['company'] ?></td>
                    <td class="border px-4 py-2"><?= $user['department'] ?></td>
                    <td class="border px-4 py-2">
                        <?php if ($user['isAdmin'] == 1) : ?>
                            <span class="bg-green-500 text-white px-2 py-1 rounded">Ja</span>
                        <?php else : ?>
                            <span class="bg-red-500 text-white px-2 py-1 rounded">Nee</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>


<?php require_once '../includes/footer.php' ?>
