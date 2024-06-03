<?php

include '../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($_POST["email"]) && empty($_POST["password"])) {
?>
        <div class="pt-4 flex justify-center">

            <div class="w-fit flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div>
                    <span class="font-medium">Erreur !</span> Veuillez remplir les champs !
                </div>
            </div>
        </div>
<?php
    } else {

        login($email, $password);
    }
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Se connecter</title>
</head>

<body class="bg-gray-900">
    <?php

    if (isset($_GET['error']) && isset($_GET['message'])) {
    ?>
        <div class="pt-4 flex justify-center">

            <div class="w-fit flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div>
                    <span class="font-medium">Erreur !</span> Adresse email ou Mot de passe incorrect !
                </div>
            </div>
        </div>
    <?php
    }
    if (isset($_GET['error']) == 4 || isset($_GET['error']) == 1) {
    ?>


        <div class="flex flex-col justify-center px-6 py-20 lg:px-8">
        <?php
    } else {
        ?>
            <div class="min-h-full flex flex-col justify-center px-6 py-20 lg:px-8">
            <?php
        }
            ?>
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-50">Se connecter</h2>
            </div>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="" method="POST">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-50">Adresse email</label>
                        <div class="mt-2">
                            <input name="email" type="email" placeholder="email@gmail.com" autocomplete="email" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-50">Mot de passe</label>
                        <div class="mt-2">
                            <input name="password" type="password" placeholder="********" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        </div>
                    </div>


                    <div>
                        <button type="submit" class="mb-5 duration-300 flex w-full justify-center rounded-md bg-white text-black hover:bg-gray-900 hover:ring-2 ring-white hover:text-white px-3 py-1.5 text-sm font-semibold leading-6 text-">Connexion</button>
                    </div>
                </form>
                <p class="mb-1 text-white">Pas de compte ?<a href="./register.php" class="ml-1 hover:underline hover:text-blue-400 text-blue-500">S'inscrire</a></p>
                <p class="text-white">Accéder <a href="../index.php" class="hover:underline hover:text-blue-400 text-blue-500">sans se connecter</a></p>
            </div>
            </div>