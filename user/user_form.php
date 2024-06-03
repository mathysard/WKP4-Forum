<?php
require_once '../functions.php';
session_start();
$users = showUser();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $password = $_POST["password"];
    $vpassword = $_POST["vpassword"];
    $image = $_FILES["image"];

    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || strlen($password) < 6) {
?>

        <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 w-5 h-5">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
            </svg>

            <div>
                <span class="font-medium">Erreur !</span> Format du mot de passe incorrect !
            </div>
        </div>

        <?php
        if (preg_match('/;/', $password)) {
        ?>
            <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 w-5 h-5">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                <div>
                    <span class="font-medium">Erreur !</span> Vous ne pouvez pas utiliser ";" comme caractère !
                </div>
            </div>
        <?php
        }
    } else {
        updateUser($firstname, $lastname, $image, $username, $email, $password, $vpassword);
    }

    if (empty($firstname && $lastname && $email && $password && $vpassword && $username)) {
        ?>
        <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 w-5 h-5">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
            </svg>
            <div>
                <span class="font-medium">Erreur !</span> Remplissez tout les champs !
            </div>
        </div>
    <?php
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $password != $vpassword) {
    $password = $_POST['password'];
    $vpassword = $_POST['vpassword'];
    ?>
    <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 w-5 h-5">
            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
        </svg>
        <div>
            <span class="font-medium ">Erreur !</span> Entrez le même mot de passe !
        </div>
    </div>
<?php
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Modification de profil</title>
</head>

<body class="bg-gray-900">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a href="./profile.php" class="w-6 flex items-center text-white ring-2 ring-white rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="duration-300 bg-white text-black hover:bg-transparent hover:text-white w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
            </a>
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-50">Modification de profil</h2><br>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="firstname" class="block text-sm font-medium leading-6 text-gray-50">Prénom </label>
                    <div class="mt-2">
                        <input <?php if (isset($_GET["id"])) { ?> value="<?= $users["firstname"];
                                                                        } ?>" name="firstname" type="text" autocomplete="firstname" placeholder="Prénom" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Modifiez votre prénom</p>
                    </div>
                </div>
                <div>
                    <label for="lastname" class="block text-sm font-medium leading-6 text-gray-50">Nom</label>
                    <div class="mt-2">
                        <input <?php if (isset($_GET["id"])) { ?> value="<?= $users["lastname"];
                                                                        } ?>" name="lastname" type="text" autocomplete="lastname" placeholder="Nom" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Modifiez votre nom</p>
                    </div>
                </div>
                <div>
                    <label for="image" class="block text-sm font-medium leading-6 text-gray-50">Image de profil</label>
                    <div class="mt-2">
                        <input name="image" type="file" autocomplete="image" placeholder="Votre photo de profil" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">


                        <p class="text-white text-xs mt-2">Modifiez votre image de profil <span class="text-yellow-500 font-bold">Ce champ n'est pas obligatoire.</span></p>
                    </div>
                </div>
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-50">Nom d'utilisateur </label>
                    <div class="mt-2">
                        <input <?php if (isset($_GET["id"])) { ?> value="<?= $users["username"];
                                                                        } ?>" name="username" type="text" autocomplete="username" placeholder="Utilisateur" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Modifiez votre nom d'utilisateur</p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-50">Adresse mail </label>
                        <div class="mt-2">
                            <input <?php if (isset($_GET["id"])) { ?> value="<?= $users["email"];
                                                                            } ?>" name="email" type="text" placeholder="" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                            <p class="text-white text-xs mt-2">Modifiez votre adresse mail</p>
                        </div>
                    </div>

                    <label for="password" class="mt-7 block text-sm font-medium leading-6 text-gray-50">A propos de vous </label>
                    <?php
                    if ($users["about"] == NULL) {
                        echo "Il n'y à rien à propos de vous";
                    }
                    ?>
                    <div class="mt-2">
                        <input <?php if (isset($_GET["id"])) { ?> value="<?= $users["about"];
                                                                        } ?>" name="about" type="text" placeholder="" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Modifiez votre mot de passe</p>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-50">Mot de passe </label>
                    <div class="mt-2">
                        <input name="password" type="password" placeholder="********" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Modifiez votre mot de passe. <span class="text-red-400">Minimum un chiffre, une lettre, et 6 caractères.</span></p>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="vpassword" class="block text-sm font-medium leading-6 text-gray-50">Confirmation du mot de passe </label>
                        <div class="text-sm">
                        </div>
                    </div>
                    <div class="mt-2">
                        <input name="vpassword" type="password" placeholder="********" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Entrez à nouveau votre mot de passe.</p>
                    </div>
                </div>

                <div>
                    <button type="submit" name="submit" class="duration-300 flex w-full justify-center rounded-md bg-white text-black hover:bg-transparent ring-2 ring-white hover:text-white px-3 py-1.5 text-sm font-semibold leading-6">Modifier</button>
                </div>
            </form>

        </div>
    </div>


</body>

</html>