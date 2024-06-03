<?php
ob_start();
require_once '../functions.php';
$title = "Profil";
require_once '../navbar/navbar.php';
if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
}

$users = showUser();

$user_role = getUserRole($_SESSION["user"]["role_id"]);

?>
<div class="bg-gray-100 p-8 rounded-md w-full">
    <div class=" flex items-center justify-between pb-6">
        <div>
        </div>
        <?php
        if ($_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2) {
        ?>
            <div class="flex items-center justify-between">
                <div class="lg:ml-40 ml-10 space-x-8">

                    <a href="./user_list.php" class="hover:shadow-2xl bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide ">Liste des utilisateurs</a>
                    <a href="../categories/category_list.php" class="hover:shadow-2xl bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide ">Liste des catégories</a>
                    <a href="../topics/topic_list.php" class="hover:shadow-2xl bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide ">Liste des sujets</a>
                    <a href="./role.php" class="hover:shadow-2xl bg-gray-900 hover:bg-transparent hover:text-gray-900 hover:ring-2 ring-gray-900 duration-300 px-4 py-2 rounded-md text-white font-semibold tracking-wide ">Rôles</a>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<form action="./update_user.php?id=<?= $_SESSION["user"]["id"] ?>" method="POST" enctype="multipart/form-data">
    <div class="bg-gray-100 pb-8 flex items-center w-full justify-center">
        <div class="w-full bg-gray-900 max-w-2xl shadow-lg shadow-gray-300 sm:rounded-lg">
            <div class="flex px-4 py-5 sm:px-6 ">
                <h3 class="w-full text-lg leading-6 font-medium text-white flex items-center">
                    Mon profil
                </h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-white">
                            Votre rôle :
                        </dt>
                        <dd class="mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                            <?php
                            if ($users["role_id"] == 1) {
                            ?>
                                <span class="text-red-700 block text-sm font-semibold"><?= $user_role["role_name"] ?></span>
                            <?php
                            } else if ($users["role_id"] == 2) {
                            ?>
                                <span class="text-green-600 block text-sm font-semibold"><?= $user_role["role_name"] ?></span>
                            <?php
                            } else if ($users["role_id"] == 3) {
                            ?>
                                <span class="text-blue-600 block text-sm font-semibold"><?= $user_role["role_name"] ?></span>
                            <?php
                            } else if ($users["role_id"] == 4) {
                            ?>
                                <span class="text-orange-500 block text-sm font-semibold"><?= $user_role["role_name"] ?></span>

                            <?php
                            }
                            ?>
                        </dd>
                    </div>
                    <div class="bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-white">
                            Nom d'utilisateur :
                        </dt>
                        <dd class="flex mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                            <input class="p-1 text-white bg-gray-900 ring-2 ring-gray-800 rounded focus:bg-gray-100 focus:text-black focus:outline-none" type="text" name="username" value="<?= $users["username"] ?>">
                        </dd>
                    </div>
                    <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-white">
                            Prénom :
                        </dt>
                        <dd class="flex mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                            <input class="p-1 text-white bg-gray-900 ring-2 ring-gray-900 rounded focus:bg-gray-100 focus:text-black focus:text-black focus:outline-none" type="text" name="firstname" value="<?= $users["firstname"] ?>">
                        </dd>
                    </div>
                    <div class="bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-white">
                            Nom :
                        </dt>
                        <dd class="flex mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                            <input class="p-1 text-white bg-gray-900 ring-2 ring-gray-800 rounded focus:bg-gray-100 focus:text-black focus:outline-none" type="text" name="lastname" value="<?= $users["lastname"] ?>">
                        </dd>
                    </div>
                    <div class="bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-white">
                            Adresse mail :
                        </dt>
                        <dd class="flex mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                            <input class="p-1 text-white bg-gray-900 ring-2 ring-gray-800 rounded focus:bg-gray-100 focus:text-black focus:outline-none" type="text" name="email" value="<?= $users["email"] ?>">
                        </dd>
                    </div>
                    <div class="bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-white">
                            Photo de profil :
                        </dt>
                        <dd class="flex mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                            <?php
                            if ($users["profile_picture"] == NULL) {

                            ?>
                                <img class="ring-2 ring-gray-800 h-10 rounded-full  max-w-12 max-h-12 mr-4" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Default_pfp.svg/340px-Default_pfp.svg.png" alt="">
                            <?php
                            } else {
                            ?>
                                <img class="ring-2 ring-gray-800 h-10 rounded-full  max-w-12 max-h-12 mr-4" src="../user_image/<?= $users["profile_picture"]; ?>" alt="">
                            <?php
                            }
                            ?>
                            <input class=" p-1 text-white bg-gray-900 ring-2 ring-gray-800 rounded focus:bg-gray-100 focus:text-black focus:outline-none" type="file" autocomplete="image" name="profile_picture">
                        </dd>
                    </div>
                    <div class="rounded-lg bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-white">
                            À propos de moi :
                        </dt>
                        <dd class="flex mt-1 text-sm text-white sm:mt-0 sm:col-span-2">
                            <textarea class="p-1 text-white bg-gray-900 ring-2 ring-gray-800 rounded focus:bg-gray-100 focus:text-black focus:outline-none" type="text" name="about" cols="50"><?= $users["about"] ?></textarea>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    </div>

    <div class="flex justify-center bg-gray-100 pb-8">
        <input type="submit" class="hover:shadow-2xl text-white bg-blue-700 hover:bg-blue-800 hover:text-white duration-300 cursor-pointer focus:ring-4 focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600" value="Modifier mon compte" />
    </div>
</form>

<div class="flex justify-center bg-gray-100">
    <a href="./delete_user.php?id=<?= $_SESSION["user"]["id"] ?>" class="duration-300 hover:shadow-2xl text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-500 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600">Supprimer mon compte</a>
</div>


<?php
require_once '../footer/footer.php';
ob_end_flush();
?>