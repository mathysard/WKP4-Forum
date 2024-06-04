<?php

session_start();

if (isset($_SESSION["user"])) {


    $pdo = new PDO("mysql:host=localhost;dbname=forum;charset=utf8;port=3306", "publicuser", "root");

    $user = $_SESSION["user"];

    $userId = $user["id"];

    $sql = "SELECT * FROM users WHERE id = ?";

    $statement = $pdo->prepare($sql);

    $statement->execute([$userId]);

    $users = $statement->fetch(PDO::FETCH_ASSOC);

    $pdo = new PDO("mysql:host=localhost;dbname=forum;charset=utf8;port=3306", "publicuser", "root");

    $sql = "SELECT * FROM roles WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$users["role_id"]]);

    $user_role = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" href="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <title><?= $title ?></title>
    </head>

    <body>
        <nav class="h-20 bg-gray-100">

            <header class="fixed inset-x-0 top-0 z-30 mx-auto w-full max-w-screen-md border border-oranb bg-gray-900 py-3 shadow  md:top-6 md:rounded-3xl lg:max-w-screen-lg">
                <div class="px-4">
                    <div class="flex items-center justify-between">
                        <div class="flex shrink-0">
                            <a href="../index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                                <img src="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png" class="h-8" alt="G4 Logo" />
                            </a>
                        </div>
                        <div class="hidden md:flex md:items-center md:justify-center md:gap-5">
                            <a href="../index.php" class="active:bg-pink-700 block py-2 px-3 duration-300 rounded bg-white text-white font-semibold md:hover:text-blue-700 md:bg-transparent md:p-0">Accueil</a>
                            <a href="../categories/c_category.php" class="active:bg-pink-700 block py-2 px-3 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Catégories</a>
                            <a href="../topics/c_topic.php" class="active:bg-pink-700 block py-2 px-3 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Sujets</a>
                            <a href="#contact" class="active:bg-pink-700 block py-2 px-3 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Contact</a>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                                <button type="button" class="flex text-sm bg-gray-900 rounded-full md:me-0 border border-white focus:ring-2 focus:ring-white" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">

                                    <?php
                                    if ($users["profile_picture"] == NULL) {

                                    ?>
                                        <img class="w-8 h-8 rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/340px-Default_pfp.svg.png" alt="">
                                    <?php
                                    } else {
                                    ?>
                                        <img class="w-8 h-8 rounded-full" src="../user_image/<?= $users["profile_picture"]; ?>" alt="">
                                    <?php
                                    }
                                    ?>
                                </button>

                                <!-- Dropdown menu -->
                                <div class="z-50 hidden my-4 text-base list-none bg-gray-900 divide-y divide-gray-100 rounded-lg shadow " id="user-dropdown">
                                    <div class="px-4 py-3">
                                        <img>
                                        <?php
                                        if ($users["role_id"] == 1) {
                                        ?>
                                            <span class="text-red-700 block text-sm font-semibold"><?= $users["username"] ?></span>
                                        <?php
                                        } else if ($users["role_id"] == 2) {
                                        ?>
                                            <span class="text-green-600 block text-sm font-semibold"><?= $users["username"] ?></span>
                                        <?php
                                        } else if ($users["role_id"] == 3) {
                                        ?>
                                            <span class="text-blue-600 block text-sm font-semibold"><?= $users["username"] ?></span>
                                        <?php
                                        } else if ($users["role_id"] == 4) {
                                        ?>
                                            <span class="text-orange-500 block text-sm font-semibold"><?= $users["username"] ?></span>

                                        <?php
                                        }
                                        ?>
                                        <span class="block text-sm  text-white"><?= $user_role["role_name"] ?></span>
                                    </div>

                                    <div class="flex flex-col py-2" aria-labelledby="user-menu-button">
                                        <!-- user -->
                                        <a href="../user/profile.php?id=<?= $users["id"] ?>" class="flex rounded hover:bg-gray-700 duration-300 p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ring-2 ring-white rounded-full text-white w-5 h-5 mr-2">
                                                <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
                                            </svg>
                                            <p class="text-sm text-white">Profil</p>
                                        </a>
                                        <!-- deconnect -->
                                        <a href="../connect/logout.php" class="flex rounded hover:bg-gray-700 duration-300 p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-white w-5 h-5 mr-2">
                                                <path fill-rule="evenodd" d="M17 4.25A2.25 2.25 0 0 0 14.75 2h-5.5A2.25 2.25 0 0 0 7 4.25v2a.75.75 0 0 0 1.5 0v-2a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 .75.75v11.5a.75.75 0 0 1-.75.75h-5.5a.75.75 0 0 1-.75-.75v-2a.75.75 0 0 0-1.5 0v2A2.25 2.25 0 0 0 9.25 18h5.5A2.25 2.25 0 0 0 17 15.75V4.25Z" clip-rule="evenodd" />
                                                <path fill-rule="evenodd" d="M14 10a.75.75 0 0 0-.75-.75H3.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 14 10Z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-sm text-white">Déconnexion</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=md:hidden>

                        <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-dropdown" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                            </svg>
                        </button>
                        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                                <li>
                                    <a href="../index.php" class="border block py-2 px-3 duration-300 rounded bg-gray-900 text-white font-semibold md:hover:text-blue-700 md:bg-transparent md:p-0">Accueil</a>
                                </li>
                                <li>
                                    <a href="../categories/c_category.php" class="border block py-2 px-3 bg-gray-900 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Catégories</a>
                                </li>
                                <li>
                                    <a href="../topics/c_topic.php" class="bg-gray-900 border block py-2 px-3 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Sujets</a>
                                </li>
                                <li>
                                    <a href="#contact" class="bg-gray-900 border block py-2 px-3 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>

        </nav>
    <?php } else {
    ?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="icon" href="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png">
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
            <title><?= $title ?></title>
        </head>

        <body>
            <!-- NAVABR -->
            <nav class="h-20 bg-gray-100">

                <header class="fixed inset-x-0 top-0 z-30 mx-auto w-full max-w-screen-md border border-white bg-gray-900 py-3 shadow md:top-6 md:rounded-3xl lg:max-w-screen-lg">
                    <div class="px-4">
                        <div class="flex items-center justify-between">
                            <div class="">
                                <a href="../index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
                                    <img src="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png" class="h-8" alt="G4 Logo" />
                                </a>
                            </div>

                            <div class="ml-32 hidden md:flex md:items-center md:justify-center md:gap-5">
                                <a href="../index.php" class=" block py-2 px-3 duration-300 rounded bg-white text-white font-semibold md:hover:text-blue-700 md:bg-transparent md:p-0">Accueil</a>
                                <a href="../categories/c_category.php" class=" block py-2 px-3 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Catégories</a>
                                <a href="../topics/c_topic.php" class=" block py-2 px-3 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Sujets</a>
                                <a href="#contact" class="block py-2 px-3 text-white font-semibold duration-300 rounded hover:bg-gray-600 hover:text md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Contact</a>
                            </div>
                            <div class="flex items-center justify-end gap-3">
                                <a href="../connect/register.php" class="flex justify-center items-center bg-white py-2 px-3 rounded-xl text-sm font-semibold hover:bg-transparent border-2 border-white duration-300 hover:text-white">S'inscrire</a>
                                <a href="../connect/login.php" class="flex justify-center items-center bg-white py-2 px-3 rounded-xl text-sm font-semibold hover:bg-transparent border-2 border-white duration-300 hover:text-white">Se connecter</a>
                            </div>
                        </div>
                        <div class=md:hidden>

                            <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-dropdown" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                                </svg>
                            </button>
                            <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                                    <li>
                                        <a href="../index.php" class="border block py-2 px-3 duration-300 rounded bg-gray-900 text-white font-semibold md:hover:text-blue-700 hover:border-2 hover:border-gray-900 hover:text-gray-900 hover:bg-white md:p-0">Accueil</a>
                                    </li>
                                    <li>
                                        <a href="../categories/c_category.php" class="border block py-2 px-3 bg-gray-900 text-white font-semibold duration-300 rounded hover:bg-white hover:border-2 hover:text-gray-900 hover:border-gray-900 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Catégories</a>
                                    </li>
                                    <li>
                                        <a href="../topics/c_topic.php" class="bg-gray-900 border block py-2 px-3 text-white font-semibold duration-300 rounded rounded hover:bg-white hover:border-2 hover:text-gray-900 hover:border-gray-900 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Sujets</a>
                                    </li>
                                    <li>
                                        <a href="#contact" class="bg-gray-900 border block py-2 px-3 text-white font-semibold duration-300 rounded rounded hover:bg-white hover:border-2 hover:text-gray-900 hover:border-gray-900 md:hover:bg-transparent md:hover:text-blue-700 md:p-0">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
            </nav>
            <script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>
        <?php } ?>