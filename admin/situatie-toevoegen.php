<?php

session_start();

$title = 'Admin situaties aanmaken';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

$previous = $_GET['previous'] ?? null;

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}

if (isset($_POST['aanmaken'])) {
    $name = trim($_POST['name']);
    $qa = trim($_POST['qa']);

    if (empty($name) || empty($qa)) {
        $empty = true;
    } else {
    // Als er een nieuwe situatie word toegevoegd aan een andere situatie
        if (isset($previous)) {
            // haal department en panel op van de vorige situatie
            $sql = "SELECT * FROM `dialogs` WHERE `uuid` = ?";
            $previous_situation = $db->select($sql, [$previous]);
            $previous_situation = $previous_situation[0];

            $department = $previous_situation['department'];
            $panel = $previous_situation['panel'];

            // if next_dialog is not null then update the next_dialog_urls
            if ($previous_situation['next_dialogs'] != null) {
                $next_dialogs = $previous_situation['next_dialogs'] . ', ' . $name;
                $next_dialogs_urls = $previous_situation['next_dialogs_urls'] . ', ' . $previous;
            } else {
                $next_dialogs = $name;
                $next_dialogs_urls = $previous;
            }

            $sql = "INSERT INTO `dialogs` (title, qa, department, panel, previous_dialog, next_dialogs, next_dialogs_urls, is_root) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $db->query($sql, [$name, $qa, $department, $panel, $previous, "", "", 0]);

            // Get the uuid of the new situation
            $sql = "SELECT `uuid` FROM `dialogs` WHERE `title` = ?";
            $new_situation = $db->select($sql, [$name]);
            $new_situation = $new_situation[0]['uuid'];

            // Update the next_dialogs_urls of the previous situation
            $sql = "UPDATE `dialogs` SET `next_dialogs` = ?, `next_dialogs_urls` = ? WHERE `uuid` = ?";
            $db->update($sql, [$next_dialogs, $new_situation, $previous]);

            $success = true;

            header("refresh:1;url=/admin/situatie-aanpassen.php?uuid=$previous");
        } else {
            $department = trim($_POST['department']);
            $panel = trim($_POST['panel']);

            if (empty($department) || empty($panel)) {
                $empty = true;
            } else {
                $sql = "INSERT INTO `dialogs` (title, qa, department, panel, previous_dialog, next_dialogs, next_dialogs_urls, is_root) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $db->query($sql, [$name, $qa, $department, $panel, "", "", "", 1]);
            }

            $success = true;

            header("refresh:1;url=/admin/situaties.php");
        }
    }
}

?>

<div class="container mx-auto mt-8 p-5">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Situatie aanmaken</h1>

        <a href="/admin/situaties.php" class="bg-primary text-white px-4 py-2 rounded">Terug naar alle situaties</a>
    </div>
    <div class="mt-8">
        <form method="post">
            <?php if (isset($success)) : ?>
                <div class="bg-green-100 border px-4 py-3 my-5 rounded relative border-green-500" role="alert">
                    <strong class="font-bold">Gelukt!</strong>
                    <span class="block sm:inline">De situatie is aangemaakt.</span>
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
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="name" name="name" type="text" placeholder="Naam">
            </div>
            <?php if (!isset($previous)) : ?>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
                        Afdeling
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                    leading-tight focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="department" name="department">
                        <?php
                        // Get the departments from database sql
                        $sql = "SELECT * FROM `departments`";
                        $departments = $db->select($sql);
                        foreach ($departments as $department) :
                            ?>
                            <option value="<?= $department['uuid'] ?>"><?= $department['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="panel">
                        Panel
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                    focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="panel" name="panel">
                        <?php
                        // Get the dialog panels from database sql
                        $sql = "SELECT * FROM `dialog_panels`";
                        $dialog_panels = $db->select($sql);
                        foreach ($dialog_panels as $dialog_panel) :
                            ?>
                            <option value="<?= $dialog_panel['uuid'] ?>"><?= $dialog_panel['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="qa">
                    qa
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                leading-tight focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>"
                id="qa" name="qa" type="text" placeholder="Vraag en/of antwoord"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" name="aanmaken" class="bg-primary text-white px-4 py-2 rounded">Aanmaken</button>
                <?php if (isset($previous)) : ?>
                    <a href="/admin/situatie-aanpassen.php?uuid=<?= $previous ?>" class="bg-gray-500 text-white px-4 py-2 rounded">Annuleren</a>
                <?php endif ?>
            </div>

        </form>
    </div>





</div>


<?php require_once '../includes/footer.php' ?>
