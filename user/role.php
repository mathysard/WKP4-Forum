<?php
require_once '../functions.php';
$title = "Attributions de rôle";
require_once '../navbar/navbar.php';

$buttonText = "Ajouter";

$users = users();
$roles = roles();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submit = $_POST["username"];

    $role = $_POST["role"];
    $set_roles = setRole($role, $submit);
}

?>
<div class="flex justify-center bg-gray-100">

    <form class="flex flex-col w-25 items-center mt-28" method="POST">
        <h1 class="mb-20 font-bold text-xl bg-gray-200 p-2 shadow-lg rounded text-gray-900">Attribution de rôle</h1>
        <div>
            <?php if (isset($_POST["submitted"])) {

                $role = selectRolesById();


                $user = selectUserById();
            ?>
                <div class="flex items-center p-2 rounded-lg shadow-2xl mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ring-2 ring-green-500 text-green-500 rounded-full w-5 h-5">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>

                    <?php
                    if ($user["role_id"] == 1) {
                    ?>

                        <p class="m-2 font-semibold">Le rôle <span class="text-red-700 ">"<?= $role["role_name"] ?>"</span> a bien été attribué a <span class="text-red-700">"<?= $user["username"] ?>"</span></p>
                        <?php
                        ?>
                    <?php
                    } elseif ($user["role_id"] == 2) {
                    ?>
                        <p class="m-2 font-semibold">Le rôle <span class="text-green-600">"<?= $role["role_name"] ?>"</span> a bien été attribué a <span class="text-green-600">"<?= $user["username"] ?>"</span></p>
                    <?php
                    } elseif ($user["role_id"] == 3) {
                    ?>
                        <p class="m-2 font-semibold">Le rôle <span class="text-blue-600">"<?= $role["role_name"] ?>"</span> a bien été attribué a <span class="text-blue-600">"<?= $user["username"] ?>"</span></p>
                    <?php
                    } elseif ($user["role_id"] == 4) {
                    ?>
                        <p class="m-2 font-semibold">Le rôle <span class="text-orange-500">"<?= $role["role_name"] ?>"</span> a bien été attribué a <span class="text-orange-500">"<?= $user["username"] ?>"</span></p>
                <?php
                    }
                }
                ?>
                </div>
        </div>
        <section class="bg-gray-100 flex justify-center">

            <div class="bg-gray-100 w-80 p-2 rounded-2xl shadow-2xl flex flex-col items-center">

                <div class="mb-3 flex flex-col w-72">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <select class="cursor-pointer rounded-full" name="username">
                        <?php foreach ($users as $user) { ?>
                            <option value="<?= $user["id"] ?>" <?php if (isset($_GET["id"])) {
                                                                    if ($user["role_id"] == $role["id"]) {
                                                                ?> selected<?php
                                                                    }
                                                                } ?>>
                                <?= $user["username"] ?>
                            </option>
                        <?php }; ?>
                    </select>
                </div>
                <div class="mb-3 flex flex-col w-72">
                    <label for="role" class="form-label">roles</label>
                    <select class="cursor-pointer rounded-full" name="role">
                        <?php foreach ($roles as $role) { ?>
                            <option value="<?= $role["id"] ?>" <?php if (isset($_GET["id"])) {
                                                                    if ($user["role_id"] == $role["id"]) {
                                                                ?> selected <?php
                                                                    }
                                                                } ?>>
                                <?= $role["role_name"] ?>
                            </option>
                        <?php }; ?>
                    </select>
                </div>
                <div class="flex justify-center w-72">

                    <button type="submit" name="submitted" class="mt-10 w-52 bg-gray-900 text-white rounded-lg hover:bg-transparent border-2 border-gray-900 hover:text-gray-900 duration-300 font-semibold p-2">
                        <?= $buttonText ?>
                    </button>
                </div>
            </div>
        </section>
    </form>
</div>
<?php
?>


<head>
    <script src="https://unpkg.com/tailwindcss-jit-cdn"></script>
</head>

<body>

</body>

</html>


<?php
require_once '../footer/footer.php';
