<?php
require_once './functions.php';

$limit_categories = topicLimit();



?>

<div class="bg-gray-100 flex justify-center">
    <p class="flex justify-center text-gray-900 p-2 mb-10 mt-10 rounded-lg font-medium text-3xl w-48 shadow-lg">Sujet récents</p>
</div>

<?php
if ($limit_categories !== NULL) {
?>

<?php
}
?>

<section class="bg-gray-100 flex items-center justify-center flex-wrap w-full">
    <?php
    foreach ($limit_categories as $limit_category) {
        if ($limit_category["is_deleted"] == 0 && $limit_category["is_active"] == 1) {
            $category = showCategoryByTopics($limit_category["category_id"]);

    ?>
            <div class="hover:scale-105 hover:shadow-2xl duration-500 max-w-sm p-6 bg-gray-900 border border-gray-200 rounded-lg shadow md:ml-5 mb-5">
                <a href="../topics/read_topic.php?id=<?= $limit_category["id"] ?>" class="w-full mb-2 text-2xl font-bold tracking-tight text-white">
                    <p class="text-center"><?= html_entity_decode($limit_category["title"]) ?></p>
                </a>
                <div class="flex justify-center">
                    <span class="font-semibold px-1 mt-2 text-xs text-gray-500"><?= html_entity_decode(mb_strimwidth($limit_category["message"], 0, 50, "...")); ?></span>
                </div>
                <div class="flex justify-center">
                    <span class="font-semibold px-1 text-lg text-blue-500">Catégorie : <a class="underline underline-offset-2" href="../topics/topics_by_category.php?id=<?= $category["id"]?>"><?= html_entity_decode($category["category"])?></a></span>
                </div>
                <div class="h-20 w-80 mb-3 font-normal text-gray-700 "></div>
                <a href="../topics/read_topic.php?id=<?= $limit_category["id"] ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-black bg-white duration-300 hover:text-white rounded-lg hover:bg-transparent ring-2 ring-white">
                    Lire
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>

    <?php
        }
    }
    ?>
</section>