<?php
require_once '../functions.php';

// Validate topic ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ./c_topic.php?error=14&message=Invalid topic ID");
}

$topic = topicFromId($_GET['id']);

// Check if the topic is deleted and inactive
if ($topic["is_deleted"] == 1 && $topic["is_active"] == 0) {
    header("Location: ./c_topic.php?error=13&message=Ce sujet n'existe plus");
}

$title = $topic["title"];
require_once '../navbar/navbar.php';

$usersData = userData($topic["created_by"]);
$user_role = getSpecificUserRole($usersData["role_id"]);
$users = showUser();
$comments = comments();

if ($topic["is_active"] == 1 && $topic["is_deleted"] == 0) {
    if (isset($_SESSION["user"]) && isset($_POST["delete"])) {
        deleteTopic($_GET["id"]);
    }
} else {
    $id = $_GET["id"];
    header("Location: ./read_topic.php?error=9&message=Session non-active&id=$id");
}
?>
<div class="bg-gray-100">
    <div class="container mx-auto p-5 flex antialiased text-gray-900 bg-gray-100">
        <div class="w-3/4">
            <?php if ($topic["is_deleted"] == 0 && $topic["is_active"] == 1) { ?>
                <section>
                    <div class="text-2xl mb-4"><?= html_entity_decode($topic["title"]) ?></div>
                    <?php
                    if (isset($_SESSION["user"])) {

                    ?>
                        <a href="#repondre" class="flex items-center bg-gray-900 text-white rounded p-1 w-28 mb-7 duration-300 hover:bg-transparent hover:text-gray-900 hover:ring-2 hover:ring-gray-900">
                            Répondre
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ml-2 w-5 h-5">
                                <path fill-rule="evenodd" d="M7.793 2.232a.75.75 0 0 1-.025 1.06L3.622 7.25h10.003a5.375 5.375 0 0 1 0 10.75H10.75a.75.75 0 0 1 0-1.5h2.875a3.875 3.875 0 0 0 0-7.75H3.622l4.146 3.957a.75.75 0 0 1-1.036 1.085l-5.5-5.25a.75.75 0 0 1 0-1.085l5.5-5.25a.75.75 0 0 1 1.06.025Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php
                    } else {
                    ?>
                        <div class="p-1 w-28 mb-16 "></div>
                    <?php
                    }
                    ?>
                    <div class="text-white bg-gray-900 p-3 rounded mb-7">
                        <div class="font-semibold"><?= nl2br(html_entity_decode($topic["message"])) ?></div>
                        <div class="mb-5 mt-3 flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            par <span class="ml-1 mr-1 text-red-600"><?= mb_strimwidth(html_entity_decode($usersData["username"]), 0, 50, "...") ?></span> le <?= html_entity_decode($topic["created_at"]) ?>
                        </div>
                        <?php foreach ($comments as $comment) { ?>
                            <?php if ($comment["is_active"] == 1 && $comment["is_deleted"] == 0) { ?>
                                <div class="bg-gray-100 p-3 rounded mb-4">
                                    <div class="flex items-center mb-2">
                                        <img class="ring-1 ring-white mr-2 w-10 h-10 rounded-full" src="../user_image/<?= html_entity_decode($comment["pp"]) ?>" alt="Profile Picture">
                                        <p class="mr-2 text-red-600"><?= mb_strimwidth(html_entity_decode($comment["username"]), 0, 50, "...") ?></p>
                                    </div>
                                    <div class="font-semibold text-black">
                                        <?= nl2br(html_entity_decode($comment["message"])) ?>
                                    </div>
                                    <?php if (isset($_SESSION["user"]) && ($comment["commentUser"] == $_SESSION["user"]["id"] || $_SESSION["user"]["role_id"] <= 2)) { ?>
                                        <div class="flex justify-end mt-2">
                                            <a href="./update_form_comment.php?comment_id=<?= $comment['commentId'] ?>&id=<?= $_GET["id"] ?>" class="duration-300 text-green-500 hover:text-green-700 mr-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                                    <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                                </svg>
                                            </a>

                                            <a href="./delete_comment.php?comment_id=<?= $comment['commentId'] ?>&id=<?= $_GET["id"] ?>" class="text-red-700 hover:text-red-900"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>
                                    <?php } else {
                                    ?>
                                        <div></div>
                                    <?php
                                    } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if (isset($_SESSION["user"])) { ?>
                            <form action="./insert_comment.php?id=<?= $_GET["id"] ?>" method="POST" class="mt-7">
                                <textarea rows="5" name="comment" id="repondre" placeholder="Votre commentaire" class="text-black font-semibold w-full p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-600" required></textarea>
                                <div class="mt-4 flex justify-end">
                                    <button type="submit" name="submit" class="px-4 py-2 bg-white text-black rounded font-semibold hover:text-white hover:bg-transparent hover:ring-2 hover:ring-white duration-300">Envoyer votre commentaire</button>
                                </div>
                            </form>
                        <?php } else { ?>

                            <div class="mt-7 p-4 bg-gray-900 text-white rounded">
                                <p>Il faut <a class="text-blue-700" href="../connect/login.php">se connecter</a> ou <a class="text-blue-700" href="../connect/register.php">s'inscrire</a> pour poster un commentaire.</p>
                            </div>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION["user"]) && ($_SESSION["user"]["role_id"] == 1 || $_SESSION["user"]["role_id"] == 2 || $_SESSION["user"]["id"] == $topic["user_id"])) { ?>
                    <div class="flex justify-end mt-7">
                        <a href="./topic_form.php?topic_id=<?= $topic["id"] ?>" class="mr-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Modifier</a>
                        <form method="POST">
                            <button type="submit" name="delete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
                        </form>
                    </div>
                <?php } ?>
                </section>
            <?php } else {
                header("Location: ./c_topic.php");
                exit();
            } ?>
        </div>
        <div class="w-1/4">
            <div class="mt-28 bg-gray-900 text-white rounded p-4">
                <img class="w-full h-56 object-cover rounded mb-4" src="../user_image/<?= html_entity_decode($usersData["profile_picture"]) ?>" alt="Profile Picture">
                <p class="text-red-600 mb-2"><?= html_entity_decode(mb_strimwidth($usersData["username"], 0, 40, "...")); ?></p>
                <p><?= html_entity_decode($user_role["role_name"]) ?></p>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../footer/footer.php';
?>