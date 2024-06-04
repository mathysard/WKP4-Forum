<?php
ob_start();
require_once '../functions.php';
$title = "Restore";
require_once '../navbar/navbar.php';

if($_SESSION["user"]["role_id"] !== 1 && $_SESSION["user"]["role_id"] !== 2) {
    header("Location: ./c_category.php");
}
if (isset($_SESSION["user"])) {
    $users = users();

    // if (isset($_POST["search"])) {
    //     $search = $_POST["search"];
    //     $usersSearch = searchUsers($_POST["search"]);
    //     $categories = searchCategory($search);
    // }


?>
    <div class="bg-gray-100 p-8 rounded-md w-full">
        <div class=" flex items-center justify-between pb-6">
            <div>
                <a href="../categories/category_list.php" class="bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide">Liste des catégories</a>
                <a href="../topics/topic_list.php" class="bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide">Liste des sujets</a>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex bg-gray-50 items-center p-2 rounded-md">

                    <!-- <form action="" method="POST" class="flex">
                        <input class="bg-gray-50 outline-none ml-1 block " type="text" name="search" id="" placeholder="recherche...">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>

                        </button>
                    </form> -->
                </div>
            </div>
        </div>
        <div>
            <div class="mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="mb-10 w-full flex justify-center">

                    <?//php
                    // if(isset($_POST["search"])) {
                        // if ($usersSearch == NULL) {
                        // ?>
                            <!-- <p class="bg-gray-200 shadow-lg p-3 w-72 flex justify-center rounded-lg">
                                Aucun résultat trouvé pour "<?//= $search ?>"
                            </p>
    
                    </div>
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden"> -->
                    <?//php
                        // }
                    // }
                ?>
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nom de l'utilisateur
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
                    foreach ($users as $user) {
                        
                    ?>
                        <tbody>
                            <tr class="border-b bg-white shadow-2xl">
                                <td>
                                    <div class="w-fit">
                                        <div class="py-1 px-6"><?= html_entity_decode(mb_strimwidth($user["username"], 0, 50, "...")) ?></div>
                                    </div>
                                </td>
                                <td class="py-2 px-6">
                                    <?php
                                    $date = date_create("$user[created_at]");
                                    echo date_format($date, "d/m/Y | H:i");
                                    ?>
                                </td>
                                <td class="py-2 px-6">
                                    <?php
                                    if ($user["is_active"] == 1) {
                                    ?>
                                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                            <span class="relative">Actif</span>
                                </td>
                                <td>
                                    <form method="post" action="./list_delete.php?id=<?= $user["id"] ?>">
                                        <input type="hidden" name="id" value="<?= $user["id"] ?>">
                                        <input type="submit" name="delete" class="cursor-pointer font-medium text-red-600 hover:text-red-700" value="Désactiver">
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
                                    <form method="post" action="./list_restore.php?id=<?= $user["id"] ?>">
                                        <input type="hidden" name="id" value="<?= $user["id"] ?>">
                                        <input type="submit" name="restore" class="cursor-pointer text-green-500 font-medium hover:text-green-700" value="Activer">
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
} else {
    header("Location: ../index.php");
}
ob_end_flush();
