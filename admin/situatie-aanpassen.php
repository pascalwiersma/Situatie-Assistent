<?php

session_start();

$title = 'Admin situaties aanpassen';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

$situatie_uuid = $_GET['uuid'];

// Get the situation from database sql
$sql = "SELECT * FROM `dialogs` WHERE `uuid` =  ?";
$situatie = $db->select($sql, [$situatie_uuid]);
$situatie = $situatie[0];

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}

if (!$situatie) {
    header('Location: /admin/situaties.php');
    exit;
}


$naam = $situatie['title'];
$qa = $situatie['qa'];
$next_dialogs = $situatie['next_dialogs'];
$next_dialogs_urls = $situatie['next_dialogs_urls'];

if (isset($_POST['opslaan'])) {
    $name = trim($_POST['name']);
    $department = trim($_POST['department']);
    $panel = trim($_POST['panel']);
    $qa = trim($_POST['qa']);

    if (empty($name) || empty($department) || empty($panel) || empty($qa)) {
        $empty = true;
    } else {
        $sql = "UPDATE `dialogs` SET `title` = ?, `department` = ?, `panel` = ?, `qa` = ? WHERE `uuid` = ?";
        $db->update($sql, [$name, $department, $panel, $qa, $situatie_uuid]);

        $success = true;

        header("refresh:1;url=/admin/situatie-aanpassen.php?uuid=$situatie_uuid");
    }
}


?>

<div class="container mx-auto mt-8 p-5">

    <div class="mt-8">
        <form method="post">
            <?php if (isset($success)) : ?>
                <div class="bg-green-100 border px-4 py-3 my-5 rounded relative border-green-500" role="alert">
                    <strong class="font-bold">Gelukt!</strong>
                    <span class="block sm:inline">De situatie is aangepast.</span>
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
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none
                focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>"
                id="name" name="name" type="text" placeholder="Naam" value="<?= $naam ?>">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
                    Afdeling
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none
                focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="department" name="department">
                    <?php
                    // Get the departments from database sql
                    $sql = "SELECT * FROM `departments`";
                    $departments = $db->select($sql);
                    foreach ($departments as $department) :
                        ?>
                        <option value="<?= $department['uuid'] ?>" <?= $department['uuid'] == $situatie['department'] ? 'selected' : '' ?>><?= $department['name'] ?></option>
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
                        <option value="<?= $dialog_panel['uuid'] ?>" <?= $dialog_panel['uuid'] == $situatie['panel'] ? 'selected' : '' ?>><?= $dialog_panel['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="qa">
                    qa
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none
                focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>"
                id="qa" name="qa" type="text" placeholder="qa"><?= $qa ?></textarea>
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

    <div class="my-4">
        <h2 class="block text-gray-700 font-bold mt-8 text-xl">
            Gekoppelde vragen aan deze situatie
        </h2>

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

                $sql = "SELECT * FROM `dialogs` WHERE `is_root` = 0 AND `previous_dialog` LIKE '%$situatie_uuid%'";
                $situations = $db->select($sql);

                // Als er geen situatie is
                if (!$situations) {
                    echo '<tr class="hover:bg-gray-100"><td class="px-4 py-3">Er zijn (nog) geen situaties gekoppeld aan deze situatie</td></tr>';
                }

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

        <div class="mt-8">
            <a href="/admin/situatie-toevoegen.php?previous=<?= $situatie_uuid ?>" class="bg-primary text-white px-4 py-2 rounded">Situatie aanmaken</a>
        </div>

    </div>




</div>


<?php require_once '../includes/footer.php' ?>
