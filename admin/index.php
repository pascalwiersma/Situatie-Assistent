<?php

session_start();

$title = 'Admin';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/navigation.php';

if ($_SESSION['isAdmin'] === 0) {
    header('Location: /');
}

?>

<div class="container mx-auto mt-8 p-5">
    <div class="py-10 text-center">
        <h1 class="text-4xl font-bold">Admin</h1>
    </div>
    <div class="flex flex-col lg:flex-row lg:space-x-8">
        <div class="lg:w-1/3">
            <div class="bg-gray-200 p-3 rounded-md">
                <h2 class="text-2xl font-bold">Situaties</h2>
                <p class="text-gray-600">Hier kun je situaties toevoegen, bewerken en verwijderen.</p>
                <a href="/admin/situaties.php" class="mt-4 inline-block bg-primary text-white px-4 py-2 rounded">Situaties</a>
            </div>
        </div>
        <div class="lg:w-1/3 mt-8 lg:mt-0">
            <div class="bg-gray-200 p-3 rounded-md">
                <h2 class="text-2xl font-bold">Gebruikers</h2>
                <p class="text-gray-600">Hier kun je gebruikers toevoegen, bewerken en verwijderen.</p>
                <a href="/admin/gebruikers.php" class="mt-4 inline-block bg-primary text-white px-4 py-2 rounded">Gebruikers</a>
            </div>
        </div>
        <div class="lg:w-1/3 mt-8 lg:mt-0">
            <div class="bg-gray-200 p-3 rounded-md">
                <h2 class="text-2xl font-bold">Situatie categorieën</h2>
                <p class="text-gray-600">Hier kun je categorieën toevoegen, bewerken en verwijderen.</p>
                <a href="/admin/categorieen.php" class="mt-4 inline-block bg-primary text-white px-4 py-2 rounded">Categorieën</a>
            </div>
        </div>
    </div>
</div>


<?php require_once '../includes/footer.php' ?>
