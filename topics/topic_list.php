<?php
ob_start();
require_once '../functions.php';
$title = "Sujets";
require_once '../navbar/navbar.php';
$topics = showTopicsOnHomePage();

$user_role = getUserRole();

$users = showUser();

if($_SESSION["user"]["role_id"] !== 1 && $_SESSION["user"]["role_id"] !== 2) {
    header("Location: ./topic.php");
}

if (isset($_POST["search"])) {
    $search = htmlspecialchars($_POST["search"]);

    $topics = searchTopics($search);
}
?>
<div class="bg-gray-100 p-8 rounded-md w-full">
    <div class=" flex items-center justify-between pb-6">
        <div>
            <a href="./topic_list.php" class="bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide">Liste des sujets</a>
            <a href="../categories/category_list.php" class="bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide">Liste de catégories</a>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex bg-gray-50 items-center p-2 rounded-md">

                <form action="" method="POST" class="flex">
                    <input class="bg-gray-50 outline-none ml-1 block " type="text" name="search" id="" placeholder="recherche...">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>

                    </button>
                </form>
            </div>
            <div class="lg:ml-40 ml-10 space-x-8">
                <a href="../categories/category_form.php" class="bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide">Ajouter</a>
            </div>
        </div>
    </div>
    <div>
        <div class="mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="mb-10 w-full flex justify-center">

                <?php
                if ($topics == NULL) {
                ?>
                    <p class="bg-gray-200 shadow-lg p-3 w-72 flex justify-center rounded-lg">
                        Aucun résultat trouvé pour "<?= html_entity_decode($search) ?>"
                    </p>

            </div>
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
            <?php
                }
            ?>
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nom du sujet
                        </th>
                        <th class="px-1 py-3 border-b-2 border-gray-200 bg-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Crée par
                        </th>
                        <th class="px-7 py-3 border-b-2 border-gray-200 bg-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Date de création
                        </th>
                        <th class="px-7 border-b-2 border-gray-200 bg-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-2 py-3 border-b-2 border-gray-200 bg-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Action
                        </th>

                    </tr>
                </thead>
                <?php

                foreach ($topics as $topic) {
                    if (isset($_POST["delete"])) {
                        $id = $_POST["id"];
                        deleteTopic($id);
                    }

                    if (isset($_POST["restore"])) {
                        $id = $_POST["id"];
                        restoreTopic($id);
                    }
                ?>

                    <tbody>

                        <tr class="border-b bg-white shadow-2xl">

                            <td>
                                <div class="w-fit">

                                    <a href="./read_topic.php?id=<?= $topic["id"] ?>" class="text-fit">
                                        <div class="py-1 px-6 "><?= html_entity_decode($topic["title"]) ?></div>
                                        <span class="py-4 px-6 text-xs text-gray-500"><?= html_entity_decode(mb_strimwidth($topic["message"], 0, 30, "...")); ?></span>
                                    </a>
                                </div>
                            </td>
                            <td class="py-2 px-6">
                                <?= $topic["created_by"] ?>
                                <?= html_entity_decode($user["username"]) ?>
                            </td>
                            <td class="py-2 px-6">
                                <?php
                                $date = date_create("$topic[created_at]");
                                echo date_format($date, "d/m/Y | H:i");
                                ?>
                            </td>
                            <td class="py-2 px-6">
                                <?php
                                if ($topic["is_active"] == 1) {
                                ?>
                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Actif</span>
                            </td>
                            <td>


                                <form method="post" action="./delete_list.php?id=<?= $topic["id"] ?>">
                                    <input type="hidden" name="id" value="<?= $topic["id"] ?>">
                                    <input type="submit" name="delete" class="cursor-pointer font-medium text-red-600 hover:text-red-700" value="Supprimer">
                                </form>
                            <?php
                                } else {
                            ?>
                                <span class="relative inline-block px-3 p-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                    <span class="text-red-900 relative">Inactif</span>
                                </span>
                            </td>
                            <td>
                                <form method="post" action="./restore_list.php?id=<?= $topic["id"] ?>">
                                    <input type="hidden" name="id" value="<?= $topic["id"] ?>">
                                    <input type="submit" name="restore" class="cursor-pointer text-green-500 font-medium hover:text-green-700" value="Restaurer">
                                </form>
                            </td>
                        <?php
                                }
                        ?>


                    <?php
                }

                    ?>

                        </tr>
                    </tbody>
                    <?php

                    ?>
                    </tr>
            </table>
            </div>
        </div>
    </div>
</div>
<div class="h-96 bg-gray-100">

</div>
<?php
require_once '../footer/footer.php';
ob_end_flush();
