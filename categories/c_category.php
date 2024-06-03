<?php
$title = "Catégories";

require_once '../navbar/navbar.php';

if (isset($_SESSION["user"])) {
    require_once '../functions.php';
    $users = showUser();
    $categories = showCategory();
    $user_role = getUserRole();
?>


    <div class="flex flex-col flex-1">
        <?php
        if (isset($_GET["error"])) {
        ?>
            <div class="flex justify-center items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="m-2 flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div>
                    <span class="font-medium ">Erreur ! </span> Vous n'avez pas les permissions, vous êtes <?= $user_role["role_name"] ?> !
                </div>
            </div>
        <?php
        }
        ?>
        <?php if ($_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
        ?>
            <header class="bg-gray-100 relative flex items-center justify-between flex-shrink-0 p-4">
                <div class="flex-1">
                    <div class="flex items-center justify-center">
                        <a href="./category_form.php" class="duration-300 flex justify-center bg-gray-900 ring-2 ring-gray-900 hover:bg-transparent hover:text-gray-900 text-white font-bold py-2 px-4 rounded-full">Ajouter
                            une nouvelle catégorie </a>
                    </div>
                </div>
            </header>
        <?php
        }
        ?>
        <!-- CARRD -->
        <section class="bg-gray-100 flex flex-wrap w-full justify-center">
            <?php
            foreach ($categories as $categorie) {
                if ($categorie["is_deleted"] == 0 && $categorie["is_active"] == 1) {

            ?>
                    <div class="mt-10 mb-5">
                        <div class="min-h-full max-w-80 p-4 m-2 w-96 bg-gray-900 rounded-lg shadow duration-500 hover:scale-105 hover:shadow-2xl">
                            <div class="relative overflow-hidden">
                                <div class="m-2 flex justify-center">
                                    <img class="w-96 h-64" src="../uploads/<?= $categorie["image"] ?>" alt="">
                                </div>
                                <div class="absolute inset-2 bg-black opacity-40"></div>
                                <!-- show -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <a href="../topics/topics_by_category.php?id=<?= $categorie["id"] ?>" class="bg-white text-gray-900 py-2 px-6 rounded-full font-bold hover:bg-gray-300">Voir la catégorie</a>
                                </div>
                            </div>
                            <div class=" mb-5 text-white flex flex-wrap"><?= html_entity_decode($categorie["category"]) ?></div>
                            <div class="text-gray-400"><?= mb_strimwidth(html_entity_decode($categorie["description"]), 0, 50, "...")?></div>


                            <div class="flex justify-evenly mt-5">



                                <!-- update -->
                                <?php
                                if ($_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
                                ?>
                                    <a href="./category_form.php?id=<?= $categorie["id"] ?>" class="cursor-pointer duration-300 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-green-600 bg-white rounded-lg hover:bg-transparent hover:text-green-600 ring-2 ring-white ">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                                            <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                        </svg>
                                    </a>
                                    <!-- delete -->
                                    <!-- faire un form -->

                                    <a href="./delete.php?id=<?= $categorie["id"] ?>" class="cursor-pointer ml-20 duration-300 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-red-600 bg-white rounded-lg hover:bg-transparent hover:text-red-600 ring-2 ring-white ">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </section>
    </div>
    </div>
    <?php
    require_once '../footer/footer.php';

    ?>

<?php
} else {
    require_once '../functions.php';
    $categories = showCategory();
?>

    <div class="bg-gray-100 flex flex-col flex-1">
        <div class="h-10"></div>
        <!-- CARRD -->
        <section class="flex flex-wrap w-full justify-center">
            <?php
            foreach ($categories as $categorie) {
                if ($categorie["is_deleted"] == 0 && $categorie["is_active"] == 1) {

            ?>
                    <div class="mb-5">
                        <div class="min-h-ful max-w-80 p-4 m-2 w-96 bg-gray-900 rounded-lg shadow duration-500 hover:scale-105 hover:shadow-2xl">
                            <div class="relative overflow-hidden">
                                <div class="m-2 flex justify-center">

                                    <img class="w-96 h-64" src="../uploads/<?= $categorie["image"] ?>" alt="">

                                </div>
                                <div class="absolute inset-2  bg-black opacity-40"></div>
                                <!-- show -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <a href="../topics/topics_by_category.php?id=<?= $categorie["id"] ?>" class="bg-white text-gray-900 py-2 px-6 rounded-full font-bold hover:bg-gray-300">Voir la catégorie</a>
                                </div>
                            </div>
                            <div class=" mb-5 text-white flex flex-wrap"><?= html_entity_decode($categorie["category"]) ?></div>
                            <div class="flex justify-evenly">

                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </section>
    </div>
    <script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>
    <!-- NAVBAR -->

<?php
    require_once '../footer/footer.php';
}
?>