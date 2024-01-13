<?php

session_start();

$title = 'Admin categorie aanmaken';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

$previous = $_GET['previous'] ?? null;

if (isset($_POST['aanmaken'])) {
    $naam = trim($_POST['naam']);
    $department = trim($_POST['department']);

    if (empty($naam) || empty($department)) {
        $empty = true;
    } else {
        $sql = "INSERT INTO `dialog_panels` (name, department) VALUES (?, ?)";
        $db->query($sql, [$naam, $department]);

        $success = true;

        header("refresh:1;url=/admin/categorieen.php");
    }
}

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}

?>

<div class="container mx-auto mt-8 p-5">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Categorie aanmaken</h1>

        <a href="/admin/gebruikers.php" class="bg-primary text-white px-4 py-2 rounded">Terug naar alle categorieën</a>
    </div>
    <div class="mt-8">
        <form method="post">
            <?php if (isset($success)) : ?>
                <div class="bg-green-100 border px-4 py-3 my-5 rounded relative border-green-500" role="alert">
                    <strong class="font-bold">Gelukt!</strong>
                    <span class="block sm:inline">De categorie is aangemaakt.</span>
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
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Naam
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                 id="naam" name="naam" type="text" placeholder="Naam">
            </div>


            <!-- Afdeling -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
                    Afdeling
                </label>
                <div class="relative">
                    <select class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow
                    leading-tight focus:outline-none focus:shadow-outline" id="department" name="department">
                        <option value="0">Selecteer een afdeling</option>
                        <!-- mysql departmet -->
                        <?php
                        $sql = "SELECT * FROM `departments`";
                        $departments = $db->select($sql);
                        foreach ($departments as $department) : ?>
                            <option value="<?= $department['uuid'] ?>"><?= $department['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                            <path fill="#000000" d="M9 9.5L4.5 5 3 6.5 9 12.5 17 4.5 15.5 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" name="aanmaken" class="bg-primary text-white px-4 py-2 rounded">Aanmaken</button>
            </div>

        </form>
    </div>





</div>


<?php require_once '../includes/footer.php' ?>
