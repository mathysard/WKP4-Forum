<?php
session_start();
require_once '../functions.php';

if (isset($_GET["category_id"])) {

    $topicsData = selectTopicsById();

    // if ($topicsData == NULL) {
    //     header("Location: ./c_topic.php?error=18&message=Cette catégorie n'existe pas");
    // }
} elseif(isset($_GET["id"])) {
    $topicsData = topicFromId();
} elseif(isset($_GET["topic_id"])) {
    $topicsData = topicFromIdGetTopic();
} elseif(!isset($_GET["category_id"])) {
    // header("Location: ./c_topic.php");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $message = $_POST["message"];

    if (strlen($_POST["title"]) > 30) {
        header("Location: ./topic_form.php?error=Plus de 30 caractères insérés dans le nom du sujet.");
    } else {
        if (isset($_GET["id"]) && $_SESSION["user"]["role_id"] == 1 || isset($_GET["id"]) && $_SESSION["user"]["role_id"] == 2 || isset($_GET["id"]) && $topicsData["user_id"] == $_SESSION["user"]["id"]) {
            $id = $_GET["id"];
            updateTopic($title, $message, $id);
            header("Location: ./read_topic.php?id=" . $_GET["id"]);
        } elseif(isset($_GET["topic_id"]) && $_SESSION["user"]["role_id"] == 1 || isset($_GET["topic_id"]) && $_SESSION["user"]["role_id"] == 2 || isset($_GET["topic_id"]) && $topicsData["user_id"] == $_SESSION["user"]["id"]) {
            $id = $_GET["id"];
            updateTopic($title, $message, $_GET["topic_id"]);
            header("Location: ./read_topic.php?id=" . $_GET["topic_id"]);
        } else {
            createTopic($title, $message);
            header("Location: ./c_topic.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Création de sujet</title>
</head>
<body class="bg-gray-900">
    <?php
    if (isset($_GET['error'])) {

    ?>
        <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="m-2 flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div>
                <span class="font-medium ">Erreur ! </span> Il y a plus de 30 caractères !
            </div>
        </div>
    <?php
    }
    ?>
    <div class="mt-10 sm:mx-auto sm:max-w-sm">
        <?php if(isset($_GET["category_id"])) {
            ?>
            <a href="./topics_by_category.php?id=<?= $_GET["category_id"] ?>" class="w-6 flex items-center text-white ring-2 ring-white rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="duration-300 bg-white text-black hover:bg-transparent hover:text-white w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
            </a><?php
        } else {
            ?>
            <?php if(isset($_GET["id"])) {
                ?>
                <a href="./read_topic.php?id=<?= $_GET["id"] ?>" class="w-6 flex items-center text-white ring-2 ring-white rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="duration-300 bg-white text-black hover:bg-transparent hover:text-white w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                    </svg>
                </a><?php
            } elseif(isset($_GET["topic_id"])) {
            ?>
            <a href="./read_topic.php?id=<?= $_GET["topic_id"] ?>" class="w-6 flex items-center text-white ring-2 ring-white rounded">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="duration-300 bg-white text-black hover:bg-transparent hover:text-white w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
            </a><?php
            }
        }?>
        <form class="space-y-6" method="POST" enctype="multipart/form-data">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-white"><?php if (!isset($_GET["id"]) && !isset($_GET["topic_id"])) {
                                                                                                            echo "Nouveau";
                                                                                                        } else {
                                                                                                            echo "Modification du";
                                                                                                        } ?> sujet</h2>
            </div>
            <div>
                <label class="block font-medium leading-6 text-white">Nom du sujet</label>
                <p class="text-sm text-red-500">Maximum 30 caractères </p>
                <div class="mt-2">
                </div>
                <input <?php if (isset($_GET["id"]) || isset($_GET["topic_id"])) { ?> value="<?= $topicsData["title"];
                                                                } ?>" name="title" type="text" placeholder="Nom du sujet" class="font-semibold block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-400 focus:outline-none" required>
            </div>

            <div>
                <label class="block font-medium leading-6 text-white">Message</label>
                <div class="mt-2">
                </div>
                <textarea rows="5" name="message" type="text" placeholder="votre message" class="resize-none font-semibold block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-400 focus:outline-none" required><?php if (isset($_GET["id"]) || isset($_GET["topic_id"])) {
                                                                                                                                                                                                                                                                                            echo $topicsData["message"];
                                                                                                                                                                                                                                                                                        } ?></textarea>
            </div>

            <button type="submit" class="mt-28 duration-300 flex w-full justify-center rounded-md bg-white text-black hover:bg-gray-900 ring hover:ring-2 ring-white hover:text-white px-3 py-1.5 text-sm font-semibold leading-6 text-">
                <?php if (isset($_GET["id"])) {
                    echo "Modifier";
                } else {
                    echo "Ajouter";
                } ?></button>

        </form>
    </div>