   

<?php

session_start();

if(!isset($_SESSION["user"])) {
    header("Location: ./c_topic.php");
}

$comment_id = $_GET["comment_id"];

require_once '../functions.php';

$comment = selectCommentById();

if(isset($_POST["submit"])) {
    if(empty($_POST["message"])) {
        header("Location: ./update_comment_form.php?comment_id=$comment_id&error=16&message=Veuillez remplir le message");
    }
}

?>
<div class="hidden">
    <?php
    $title = "Modification";
    require_once '../navbar/navbar.php';
    ?>
</div>

<body class="bg-gray-900">

    <div class="mt-10 sm:mx-auto sm:max-w-sm">
        <a href="./read_topic.php?id=<?=$_GET["id"]?>" class="w-6 flex items-center text-white ring-2 ring-white rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="duration-300 bg-white text-black hover:bg-transparent hover:text-white w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
        </a>
        <form action="./update_comment.php?comment_id=<?= $_GET['comment_id']?>&id=<?= $_GET["id"]?>" method="POST">

            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-white">Modification de commentaire</h2>
            </div>
         
            <div>
                <label class="mt-10 block font-medium leading-6 text-white">Votre commentaire</label>
                <div class="mt-2">
                </div>
                <textarea rows="5" name="message" type="text" placeholder="..." class="resize-none font-semibold block w-full px-5 py-2 border rounded-lg bg-white shadow-lg placeholder-gray-400 text-gray-700 focus:ring focus:ring-gray-400 focus:outline-none" required ><?= $comment['message'] ?></textarea>
            </div>

            <button type="submit" class="mt-28 duration-300 flex w-full justify-center rounded-md bg-white text-black hover:bg-gray-900 ring hover:ring-2 ring-white hover:text-white px-3 py-1.5 text-sm font-semibold leading-6 text-">
                Modifier</button>

        </form>
    </div>

