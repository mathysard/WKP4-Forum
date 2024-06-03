<?php
require_once '../functions.php';
$title = 'Sujet';
require_once '../navbar/navbar.php';
$topics = showTopicsOnHomePage();
$user_role = getUserRole();
$users = showUser();




if (isset($_POST["search"])) {
    $search = htmlspecialchars($_POST["search"]);
    $topics = searchTitle($search);
}

if (isset($_SESSION["user"])) {
?>

    <div class="bg-gray-100 flex items-center justify-end">
        <div class="flex bg-gray-50 items-center p-2 rounded-md m-7 border-2 border-gray-400">

            <form action="" method="POST" class="flex">
                <input class="bg-gray-50 outline-none ml-1 block " type="text" name="search" id="" placeholder="recherche...">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>

                </button>
            </form>
        </div>

    </div>
    <div class="p-10 w-full flex justify-center bg-gray-100">

        <?php
        if (isset($_POST["search"]) && $topics == NULL) {
        ?>
            <p class="bg-gray-200 shadow-lg p-3 w-72 flex justify-center rounded-lg">
                Aucun résultat trouvé pour "<?= html_entity_decode($search) ?>"
            </p>
        <?php
        }
        ?>
    </div>

    </div>
    <div class="flex justify-center bg-gray-100 pb-10">
        <span class="bg-gray-100 p-3 text-lg font-bold text-gray-900 shadow-2xl flex justify-center w-fit rounded">
            Liste de tout les sujets
        </span>
    </div>
    <div class="bg-gray-100 flex justify-center relative overflow-x-auto sm:rounded-lg">
        <table class="w-82 text-sm text-left rtl:text-right text-gray-500 shadow-2x">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Sujet
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date de création
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre de commentaires
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dernier commentaire
                    </th>

                    <?php if ($_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
                    ?>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <?php
            foreach ($topics as $topic) {

                if ($topic["is_deleted"] == 0 && $topic["is_active"] == 1) {
                    $users_last_comment = lastComment($topic);

                    // Affichage du nombre de commentaires
                    $topics_comments = countComment($topic);
            ?>
                    <tbody class="bg-gray-100 odd:bg-gray-900 even:bg-slate-800">
                        <tr>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm text-white">
                                        <a href="./read_topic.php?id=<?= $topic["id"] ?>" class="hover:text-blue-700 duration-300">
                                            <div class=" py-2"><?= html_entity_decode($topic["title"]) ?></div>
                                            <span class=" text-xs text-gray-300"><?= html_entity_decode(mb_strimwidth($topic["message"], 0, 50, "...")); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <div class="text-sm leading-5 text-white">
                                    <?php
                                    $date = date_create("$topic[created_at]");
                                    echo date_format($date, "d/m/Y | H:i");
                                    ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-white">
                                <?php if ($topics_comments == NULL) {
                                    echo "Aucun commentaire";
                                } else {
                                    echo $topics_comments;
                                } ?>
                            </td>
                            <td class="px-6 py-4 text-white">
                                <?php if ($users_last_comment == NULL) {
                                    echo "Aucun commentaire";
                                } else {
                                    $date = date_create("$users_last_comment[date]");
                                    echo date_format($date, "d/m/Y | H:i");
                                ?>
                                    <br>
                                <?php
                                    echo html_entity_decode(mb_strimwidth($users_last_comment["username"], 0, 30, "..."));
                                } ?>
                            </td>
                            <?php if ($_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
                            ?>
                                <td class="px-6 py-4">
                                    <div class="flex flex-row">
                                        <a href="./topic_form.php?id=<?= $topic["id"] ?>" class="text-green-600 hover:text-green-800 duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                            </svg>
                                        </a>
                                        <a href="./delete.php?id=<?= $topic["id"] ?>" class="text-red-700 hover:text-red-600 rounded duration-300">

                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            <?php
                            }
                            ?>
                    <?php
                }
            }
                    ?>
                        </tr>
                    </tbody>
        </table>
    </div>



    </table>
    </div>
    <?php
    require_once '../footer/footer.php';

    ?>

<?php

} else {

    $topics = showTopicsOnHomePage();


?>
    <div class="bg-gray-100 flex items-center justify-end">
        <div class="flex bg-gray-50 items-center p-2 rounded-md m-7">

            <form action="" method="POST" class="flex">
                <input class="bg-gray-50 outline-none ml-1 block " type="text" name="search" id="" placeholder="recherche...">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>

                </button>
            </form>
        </div>

    </div>
    <div class="p-10 w-full flex justify-center bg-gray-100">

        <?php
        if ($topics == NULL) {
        ?>
            <p class="bg-gray-200 shadow-lg p-3 w-72 flex justify-center rounded-lg">
                Aucun résultat trouvé pour "<?= $search ?>"
            </p>
        <?php
        }
        ?>
    </div>

    </div>
    <div class="flex justify-center bg-gray-100 pb-10">
        <span class="bg-gray-100 p-3 text-lg font-bold text-gray-900 shadow-2xl flex justify-center w-fit rounded">
            Liste de tout les sujets
        </span>
    </div>

    <div class="flex justify-center bg-gray-100 relative overflow-x-auto sm:rounded-lg">
        <table class="w-82 text-sm text-left rtl:text-right text-gray-500 shadow-2xl">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Sujet
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date de création
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre de commentaires
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dernier commentaire
                    </th>
                </tr>
            </thead>
            <?php
            foreach ($topics as $topic) {

                if ($topic["is_deleted"] == 0 && $topic["is_active"] == 1) {
                    $users_last_comment = lastComment($topic);

                    // Affichage du nombre de commentaires
                    $topics_comments = countComment($topic);
            ?>
                    <tbody class="bg-gray-100 odd:bg-gray-900 even:bg-slate-800">
                        <tr>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm text-white">
                                        <a href="./read_topic.php?id=<?= $topic["id"] ?>" class="hover:text-blue-700 duration-300">
                                            <div class=" py-2"><?= html_entity_decode($topic["title"]) ?></div>
                                            <span class=" text-xs text-gray-300"><?= html_entity_decode(mb_strimwidth($topic["message"], 0, 50, "...")); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <div class="text-sm leading-5 text-white">
                                    <?php
                                    $date = date_create("$topic[created_at]");
                                    echo date_format($date, "d/m/Y | H:i");
                                    ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-white">
                                <?php if ($topics_comments == NULL) {
                                    echo "Aucun commentaire";
                                } else {
                                    echo $topics_comments;
                                } ?>
                            </td>
                            <td class="px-6 py-4 text-white">
                                <?php if ($users_last_comment == NULL) {
                                    echo "Aucun commentaire";
                                } else {
                                    $date = date_create("$users_last_comment[date]");
                                    echo date_format($date, "d/m/Y | H:i");
                                ?>
                                    <br>
                                    <?php
                                    echo html_entity_decode(mb_strimwidth($users_last_comment["username"], 0, 20, "..."));
                                    ?>
                                <?php
                                } ?>
                            </td>
                    <?php
                }
            }
                    ?>
                        </tr>
                    </tbody>
        </table>
    </div>



    </table>
    </div>
<?php
    require_once '../footer/footer.php';
}
