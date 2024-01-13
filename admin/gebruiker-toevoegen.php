<?php

session_start();

$title = 'Admin gebruiker aanmaken';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

$previous = $_GET['previous'] ?? null;

if (isset($_POST['aanmaken'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $full_name = trim($_POST['full_name']);
    $company = trim($_POST['company']);
    $department = trim($_POST['department']);
    $isAdmin = trim($_POST['isAdmin'] ?? 0);

    if (empty($username) || empty($password) || empty($full_name) || empty($company) || empty($department)) {
        $empty = true;
    } else {
    // hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

    // first letter username to uppercase
        $username = ucfirst($username);

        $sql = "INSERT INTO `users` (username, password, full_name, company, department, isAdmin) VALUES (?, ?, ?, ?, ?, ?)";
        $db->query($sql, [$username, $password, $full_name, $company, $department, $isAdmin]);

        $success = true;

        header("refresh:1;url=/admin/gebruikers.php");
    }
}

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}

?>

<div class="container mx-auto mt-8 p-5">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Gebruiker aanmaken</h1>

        <a href="/admin/gebruikers.php" class="bg-primary text-white px-4 py-2 rounded">Terug naar alle gebruikers</a>
    </div>
    <div class="mt-8">
        <form method="post">
            <?php if (isset($success)) : ?>
                <div class="bg-green-100 border px-4 py-3 my-5 rounded relative border-green-500" role="alert">
                    <strong class="font-bold">Gelukt!</strong>
                    <span class="block sm:inline">De gebruiker is aangemaakt.</span>
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
                    Gebruikersnaam
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="username" name="username" type="text" placeholder="Gebruikersnaam">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Wachtwoord
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none
                focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="password" name="password" type="password" placeholder="Wachtwoord">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">
                    Volledige naam
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="full_name" name="full_name" type="text" placeholder="Volledige naam">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="company">
                    Bedrijf
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="company" name="company">
                    <option value="">Selecteer een bedrijf</option>
                    <?php
                    // Get the companies from database sql
                    $sql = "SELECT * FROM `companies`";
                    $companies = $db->select($sql);
                    foreach ($companies as $company) :
                        ?>
                        <option value="<?= $company['name'] ?>"><?= $company['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
                    Afdeling
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                leading-tight focus:outline-none focus:shadow-outline <?= isset($_GET['error']) ? 'border-red-500' : '' ?>" id="department" name="department">
                    <option value="">Selecteer een afdeling</option>
                    <?php
                    // Get the departments from database sql
                    $sql = "SELECT * FROM `departments`";
                    $departments = $db->select($sql);
                    foreach ($departments as $department) :
                        ?>
                        <option value="<?= $department['name'] ?>"><?= $department['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- is admin check -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="isAdmin">
                    Admin
                </label>
                <input type="checkbox" id="isAdmin" name="isAdmin" value="1">
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
