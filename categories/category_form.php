<?php
require_once '../functions.php';

if (isset($_GET["id"])) {
    $categoryData = categoryData();
}


if (isset($_GET["id"])) {
    $title = "Modification de sujet";
} else {
    $title = "Création de sujet";
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION["user"])) {
        $category = htmlspecialchars(trim($_POST["category"]));
        $description = htmlspecialchars(trim($_POST["description"]));

        if (strlen($_POST["category"]) > 40) {
            header("Location: ./category_form.php?error=Plus de 40 caractères insérés dans le nom de la catégorie");
?>
    <?php
        } else {

            if($_SESSION["user"]["role_id"] == 1 || isset($_GET["id"]) && $_SESSION["user"]["role_id"] == 2) {
                if(isset($_GET["id"])) {
                    $id = $_GET["id"];
                    updateCategory($category, $description, $id);
                } else {
                    createCategory($category, $description);
                }
            } else {
                header("Location: ./c_category.php?error=10&message=Permission non-acquises");
            }
        }
    } else {
        header("Location: ./c_category.php");
    }
}

// À fixer ; Même si le role_id du user est 1 ou 2, ça renvoie sur c_category.
if ($_SESSION["user"]["role_id"] == 3  || $_SESSION["user"]["role_id"] == 4) {

    header("Location: ./c_category.php?error=10&message=Permission non-acquises");
} else {
    ?>
<?php
}
?>





<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Nouvelle Catégorie</title>
</head>

<body class="bg-gray-900">
    <?php
    if (isset($_GET['error']) && $_GET["error"] !== 24) {

    ?>
        <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="m-2 flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div>
                <span class="font-medium ">Erreur ! </span> Il y a plus de 40 caractères !
            </div>
        </div>
    <?php
    }
    ?>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <a href="./c_category.php" class="w-6 flex items-center text-white ring-2 ring-white rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="duration-300 bg-white text-black hover:bg-transparent hover:text-white w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
        </a>
        <form class="space-y-6" method="POST" enctype="multipart/form-data">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-white"><?php if (!isset($_GET["id"])) {
                                                                                                            echo "Nouvelle";
                                                                                                        } else {
                                                                                                            echo "Modification de";
                                                                                                        } ?> catégorie</h2>
            </div>
            <div>
                <label class="block font-medium leading-6 text-white">Nom de catégorie</label>
                <p class="text-sm text-red-500">Maximum 40 caractères </p>
                <div class="mt-2">
                </div>
                <input <?php if (isset($_GET["id"])) { ?> value="<?= $categoryData["category"] ?>" <?php } ?> name="category" type="text" placeholder="Nom de la catégorie" class="font-semibold block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-400 focus:outline-none" required>
            </div>

            <div>
                <label class="block font-medium leading-6 text-white">Description</label>
                <div class="mt-2">
                </div>
                <textarea value="f§rtgèyh!ujçio" rows="5" name="description" type="text" placeholder="..." class="font-semibold resize-none block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-400 focus:outline-none" required><?php if (isset($_GET["id"])) {
                                                                                                                                                                                                                                                                                                            echo $categoryData["description"];
                                                                                                                                                                                                                                                                                                        } ?></textarea>
            </div>
            <label class="block font-medium leading-6 text-white">Image</label>
            <div class="mt-2">
            </div>
            <input class="font-semibold block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" name="image" id="img" type="file" required>
    </div>
    <div class="flex justify-center mt-10">

        <button class="font-semibold duration-300 flex w-96 justify-center rounded-md ring-2 ring-white bg-white text-black hover:bg-gray-900 hover:text-white px-3 py-1.5 text-sm font-semibold leading-6">
            <?php if (isset($_GET["id"])) {
                echo "Modifier";
            } else {
                echo "Ajouter";
            }
            ?>
        </button>
    </div>

    </form>
    </div>