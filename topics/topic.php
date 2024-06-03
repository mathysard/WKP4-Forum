<?php
require_once '../functions.php';
$title = "Sujets";
require_once '../navbar/navbar.php';
$topics = showTopicsOnHomePage();

$user_role = getUserRole();

$users = showUser();

?>
<div class="bg-gray-100 md:px-32 py-8 w-full">
    <div class="shadow overflow-hidden rounded border-b border-gray-200">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Sujet</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Commentaires</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Dernier commentaire</td>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <?php
                foreach ($topics as $topic) {

                    if ($topic["is_deleted"] == 0 && $topic["is_active"] == 1) {
                        $users_last_comment = userLastComment($topic);

                        // Affichage du nombre de commentaires

                        $topics_comments = topicsComments($topic);
                ?>
                        <tr>
                            <td class="w-1/3 text-left py-3 px-4"><a class="font-semibold hover:text-blue-700" href="./read_topic.php?id=<?= $topic["id"] ?>"><?= $topic["title"] ?></a></td>
                            <td class="text-left py-3 px-4">
                                <?php if ($topics_comments == NULL) {
                                    echo "Aucun commentaire";
                                } else {
                                    echo $topics_comments;
                                } ?>
                            </td>
                            <td class="ml-4 flex flex-row">
                                <?php if ($users_last_comment == NULL) {
                                ?>
                                    <p class="font-semibold">Aucun commentaire</p>
                                <?php
                                } else {
                                    echo $users_last_comment["date"] . "<br>";
                                    echo html_entity_decode($users_last_comment["username"]);
                                } ?>
                            </td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="w-1/3 text-left py-3 px-4">autre couleur</td>
                            <td class="text-left py-3 px-4"><a class="hover:text-blue-500" href="tel:622322662">622322662</a></td>
                            <td class="text-left py-3 px-4"><a class="hover:text-blue-500" href="mailto:jonsmith@mail.com">jonsmith@mail.com</a></td>
                        </tr>
                <?php
                    }
                }

                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
require_once '../footer/footer.php';
