<?php
include '../functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = htmlspecialchars(trim($_POST['email']));
    // $password = htmlspecialchars(trim($_POST['password']));
    // $vpassword = htmlspecialchars(trim($_POST['vpassword']));
    $password = $_POST["password"];
    $vpassword = $_POST["vpassword"];
    $username = htmlspecialchars(trim($_POST['username']));
    $about = htmlspecialchars(trim($_POST['about']));

    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || strlen($password) < 6) {
        header("Location: ./register.php?error=25&message=Mauvais format de mot de passe");
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
        if (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
        ?>
            <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 w-5 h-5">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                </svg>
                <div>
                    <span class="font-medium">Erreur !</span> Format d'e-mail incorrect !
                </div>
            </div>
        <?php
        }
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
        createUser($firstname, $lastname, $username, $email, $about, $password, $vpassword);
    }

    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($vpassword) || empty($password)) {
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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["password"] != $_POST["vpassword"]) {
    // $password = $_POST['password'];
    // $vpassword = $_POST['vpassword'];
    // header("Location: ./register.php?error=1&message=toto")
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

if (isset($_POST['username']) && !empty($_POST['username'])) {

    $users = getUserFromUsername();
    if ($users == NULL) {
        createUser($firstname, $lastname, $username, $email, $about, $password, $vpassword);
    } else {
    ?>
        <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 w-5 h-5">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
            </svg>
            <div>
                <span class="font-medium ">Erreur !</span> Nom d'utilisateur déjà utilisé !
            </div>
        </div>
    <?php
    }
}

if (isset($_POST['email']) && !empty($_POST['email'])) {

    $email = getEmailFromUsers();

    if ($email == NULL) {
        createUser($firstname, $lastname, $username, $email, $about, $password, $vpassowrd);
    } else {
    ?>
        <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 w-5 h-5">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
            </svg>
            <div>
                <span class="font-medium ">Erreur !</span> Adresse mail déjà utilisé !
            </div>
        </div>
<?php
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
    <title>Inscription</title>
</head>

<body class="bg-gray-900">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-50">S'inscrire</h2><br>
        </div>
        <p class="text-center text-white">Tous les champs avec un (<span class="text-red-600"> * </span>) doivent être obligatoirement remplis !</p>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="firstname" class="block text-sm font-medium leading-6 text-gray-50">Prénom <span class="text-red-600">*</span></label>
                    <div class="mt-2">
                        <input name="firstname" type="text" autocomplete="firstname" placeholder="Votre prénom" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Entrez votre prénom.</p>
                    </div>
                </div>
                <div>
                    <label for="lastname" class="block text-sm font-medium leading-6 text-gray-50">Nom <span class="text-red-600">*</label>
                    <div class="mt-2">
                        <input name="lastname" type="text" autocomplete="lastname" placeholder="Votre nom" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Entrez votre nom.</p>
                    </div>
                </div>
                <div>
                    <label for="image" class="block text-sm font-medium leading-6 text-gray-50">Image de profil</label>
                    <div class="mt-2">
                        <input name="image" type="file" autocomplete="image" placeholder="Votre photo de profil" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Insérez une image de profil. <span class="text-yellow-500 font-bold">Ce champ n'est pas obligatoire.</span></p>
                    </div>
                </div>
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-50">Nom d'utilisateur <span class="text-red-600">*</label>
                    <div class="mt-2">
                        <input name="username" type="text" autocomplete="username" placeholder="Utilisateur" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Entrez un nom d'utilisateur.</p>
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-50">Adresse mail <span class="text-red-600">*</label>
                    <div class="mt-2">
                        <input name="email" type="email" autocomplete="email" placeholder="email@gmail.com" class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Entrez une adresse mail valide.</p>
                    </div>
                </div>
                <div>
                    <label for="about" class="block text-sm font-medium leading-6 text-gray-50">À propos de moi </label>
                    <div class="mt-2">
                        <input name="about" type="text" autocomplete="about" placeholder="..." class="block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Entrez quelque chose à propos de vous.<span class="text-yellow-500 font-bold"> Ce champ n'est pas obligatoire.</span></p>
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-50">Mot de passe <span class="text-red-600">*</label>
                    <div class="mt-2">
                        <input name="password" id="password" type="password" placeholder="********" class="block w-full px-5 py-2 pr-12 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <div class="flex justify-center mt-4">
                            <button type="button" id="passwordButton" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="showPassword()">Afficher le mot de passe</button>
                        </div>
                        <p class="text-white text-xs mt-2">Entrez un mot de passe. <span class="text-red-400">Minimum un chiffre, une lettre, et 6 caractères.</span></p>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="vpassword" class="block text-sm font-medium leading-6 text-gray-50">Confirmation du mot de passe <span class="text-red-600">*</label>
                        <div class="text-sm">
                        </div>
                    </div>
                    <div class="mt-2">
                        <input name="vpassword" id="vpassword" type="password" placeholder="********" class="block w-full px-5 py-2 pr-12 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-600 focus:outline-none">
                        <p class="text-white text-xs mt-2">Entrez à nouveau votre mot de passe.</p>
                    </div>
                </div>

                <div>
                    <button type="submit" name="submit" class="duration-300 flex w-full justify-center rounded-md bg-white text-black hover:bg-transparent ring-2 ring-white hover:text-white px-3 py-1.5 text-sm font-semibold leading-6">S'inscrire</button>
                </div>
                <p class="text-white">Vous avez déjà un compte ?<a href="./login.php" class="hover:text-blue-400 text-blue-500"> Se connecter</a></p>
            </form>

        </div>
    </div>

    <script>
        function showPassword() {
            const passwordInput = document.getElementById("password");
            const passwordButton = document.getElementById("passwordButton");
            passwordInput.type === "password" ? passwordInput.type = "text" : passwordInput.type = "password";
            passwordInput.type === "password" ? passwordButton.textContent = "Afficher le mot de passe" : passwordButton.textContent = "Cacher le mot de passe";
        }
    </script>
</body>

</html>