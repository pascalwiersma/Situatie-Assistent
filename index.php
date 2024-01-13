<?php

session_start();

$title = 'Inloggen';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';

if (isset($_SESSION['user'])) {
    header('Location: /csd');
}

// Login handler
if (isset($_POST['submit'])) {
    // Variables
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username exists
    $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
    $result = $db->select($sql);

    if (count($result) == 1) {
        // Username exists
        $user = $result[0];

        // Check if password is correct
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['user'] = $user;
            $_SESSION['isAdmin'] = $user['isAdmin'];
            header('Location: /csd');
        } else {
            // Password is incorrect
            echo '<div class="flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3" role="alert">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-10a1
                            1 0 11-2 0 1 1 0 012 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <p>Inloggegevens zijn onjuist.</p>
                </div>';
        }
    } else {
        // Username does not exist
        echo '<div class="flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-10a1
                        1 0 11-2 0 1 1 0 012 0z"
                        clip-rule="evenodd" />
                </svg>
                <p>Inloggegevens zijn onjuist.</p>
            </div>';
    }
}



?>

<div class="flex min-h-full flex-col justify-center items-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h1 class="text-center text-4xl font-extrabold text-gray-900">Situatie Assistent</h1>
        <h2 class=" text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
            Inloggen voor medewerkers
        </h2>
    </div>

    <div class="mt-10 sm:smx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" method="post">
            <div>
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Gebruikersnaam</label>
                <div class="mt-2">
                    <input id="username" name="username" type="text"
                    required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm placeholder:text-gray-400 sm:text-sm sm:leading-6 capitalize">
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Wachtwoord</label>
                    <div class="text-sm">
                        <a href="mailto:tech@situatieassistent.nl" class="font-semibold text-indigo-600 hover:text-indigo-500">Wachtwoord vergeten? Contact Tech</a>
                    </div>
                </div>
                <div class="mt-2">
                <input id="password" name="password" type="password"
                    required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm placeholder:text-gray-400 sm:text-sm sm:leading-6">

                </div>
            </div>

            <div>
                <button type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600
                px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline
                focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Inloggen</button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-gray-500">
            Situatie Assistent is tot stand gekomen door
            <a href="/" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Pascal Services</a>
        </p>
    </div>
</div>

<?php require_once 'includes/footer.php' ?>
