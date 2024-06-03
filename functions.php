<?php

// Connexion à la DB

function DBConnect()
{
	return new PDO("mysql:host=localhost;dbname=forum;charset=utf8;port=9253", "root", "root");
}


// CRUD User + Login

function createUser($firstname, $lastname, $username, $email, $about, $password, $vpassword)
{
	session_start();
	if (isset($_SESSION["user"])) {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		if ($password != $vpassword) {
			header("Location: ./register.php?error=1&message=Entrez le même mot de passe");
		} else {

			$image = $_FILES["image"];

			$imageName = $image["name"];

			move_uploaded_file($image["tmp_name"], '../user_image/' . $imageName);

			$pdo = DBConnect();

			$sql = "INSERT INTO users (firstname, lastname, profile_picture, username, email, about, `password`, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, 4)";

			$statement = $pdo->prepare($sql);

			$statement->execute([$firstname, $lastname, $imageName, $username, $email, $about, $hashed_password]);

			header("Location: ./login.php");
		}
	} else {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		if ($password != $vpassword) {
			header("Location: ./register.php?error=1&message=Entrez le même mot de passe");
		} else {

			$image = $_FILES["image"];

			$imageName = $image["name"];

			move_uploaded_file($image["tmp_name"], '../user_image/' . $imageName);

			$pdo = DBConnect();

			$sessionUser = $_SESSION["user"];

			$user = $sessionUser["id"];

			$sql = "INSERT INTO users (firstname, lastname, profile_picture, username, email, about, `password`, role_id, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, 4, ?)";

			$statement = $pdo->prepare($sql);

			$statement->execute([$firstname, $lastname, $imageName, $username, $email, $about, $hashed_password, $user]);

			header("Location: ./login.php");
		}
	}
}

function login($email, $password)
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM users WHERE email = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$email]);

	$user = $statement->fetch(PDO::FETCH_ASSOC);

	$password_verify = password_verify($password, $user["password"]);

	if ($user && $password_verify == 1) {
		if ($user["is_active"] == 1 && $user["is_deleted"] == 0) {
			session_start();
			$_SESSION["user"] = $user;
			header("Location: ../index.php");
		} else {
			header("Location: ./login.php?error=4&message=Compte désactivé");
		}
	} else {
		header("Location: ./login.php?error=1&message=Email ou mot de passe incorrect");
	}
}

function showUser()
{
	if (isset($_SESSION["user"])) {
		$pdo = DBConnect();

		$user = $_SESSION["user"];

		$id = $user["id"];

		$sql = "SELECT * FROM users WHERE id = ?";

		$statement = $pdo->prepare($sql);

		$statement->execute([$id]);

		$users = $statement->fetch(PDO::FETCH_ASSOC);

		return $users;
	}
}


function users()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM users ORDER BY id DESC";

	$statement = $pdo->query($sql);

	$users = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $users;
}

function getUserMail($email)
{
	$pdo = DBConnect();

	$sql = "SELECT email FROM users WHERE email = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$email]);

	$users = $statement->fetch(PDO::FETCH_ASSOC);

	return $users;
}

function getUserUsername($username)
{
	$pdo = DBConnect();

	$sql = "SELECT username FROM users WHERE username = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$username]);

	$users = $statement->fetch(PDO::FETCH_ASSOC);

	return $users;
}

function updateUser($firstname, $lastname, $image, $username, $email, $about, $id)
{
	$pdo = DBConnect();

	$image = $_FILES["profile_picture"];

	$imageName = $image["name"];

	move_uploaded_file($image["tmp_name"], '../user_image/' . $imageName);

	$sessionUser = $_SESSION["user"];

	$user = $sessionUser["id"];

	date_default_timezone_set("Europe/Brussels");

	$date = date("d-m-Y H:i:s");

	$sql = "UPDATE users SET firstname = ?, lastname = ?, profile_picture = ?, username = ?, email = ?, about = ?, status = 'U', updated_at = ?, updated_by = ? WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$firstname, $lastname, $imageName, $username, $email, $about, $date, $user, $id]);

	// header("Location: ./profile.php?id=$user");
}

function updateUserNoImage($firstname, $lastname, $username, $email, $about, $id)
{
	$pdo = DBConnect();

	$sessionUser = $_SESSION["user"];

	$user = $sessionUser["id"];

	date_default_timezone_set("Europe/Brussels");

	$date = date("d-m-Y H:i:s");

	$sql = "UPDATE users SET firstname = ?, lastname = ?, username = ?, email = ?, about = ?, status = 'U', updated_at = ?, updated_by = ? WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$firstname, $lastname, $username, $email, $about, $date, $user, $id]);

	// header("Location: ./profile.php?id=$user");
}

function deleteUser($id)
{
	$pdo = DBConnect();

	$sql = "UPDATE users SET status = 'D' ,is_active = 0, is_deleted = 1 WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);
}

function restoreUser($id)
{
	$pdo = DBConnect();

	$sql = "UPDATE users SET status = 'R', is_active = 1, is_deleted = 0
			WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);
}

// CRUD Topics

function createTopic($title, $message)
{
	$pdo = DBConnect();

	$sessionUser = $_SESSION["user"];

	$user = $sessionUser["id"];

	$sql = "INSERT INTO topics (title, `message`, category_id, created_by) VALUES (?, ?, ?, ?)";

	$statement = $pdo->prepare($sql);

	$statement->execute([$title, $message, $_GET["category_id"], $user]);

	header("Location: ./c_topic.php");
}

function showTopic($id)
{
	$pdo = DBConnect();

	$sql = "SELECT topics.title AS 'title', topics.message AS 'message', categories.category AS 'categories', topics.created_by AS 'date', users.username AS 'username', users.profile_picture AS 'profile_picture', `comments`.`message` AS 'comments' FROM topics
	INNER JOIN categories
	ON topics.category_id = categories.id
	INNER JOIN users
	ON topics.user_id = users.id
	INNER JOIN `comments`
	ON `comments`.topic_id = topics.id
	WHERE topics.id AND topics_comments.topic_id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);

	$topics = $statement->fetch(PDO::FETCH_ASSOC);

	return $topics;
}

function showTopics()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM topics";

	$statement = $pdo->query($sql);

	$topics = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $topics;
}

function restoreTopic($id)
{
	$pdo = DBConnect();

	$sql = "UPDATE topics SET status = 'R', is_active = 1, is_deleted = 0
		WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);
}

function showTopicsOnHomePage()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM topics ORDER BY id DESC";

	$statement = $pdo->query($sql);

	$topics = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $topics;
}

function showTopicsByCategory($id)
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM topics
		INNER JOIN categories
		ON topics.category_id = categories.category
		WHERE categories.id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);

	$topics = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $topics;
}

function updateTopic($title, $message, $id)
{
	$pdo = DBConnect();

	$sessionUser = $_SESSION["user"];

	$user = $sessionUser["id"];

	date_default_timezone_set("Europe/Brussels");

	$date = date("Y-m-d H:i:s");

	$sql = "UPDATE topics SET title = ?, message = ?, status ='U', updated_at = ?, updated_by = ? WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$title, $message, $date, $user, $id]);

	header("Location: ./c_topic.php");
}

function deleteTopic($id)
{
	$pdo = DBConnect();

	$sql = "UPDATE topics SET status = 'D', is_active = 0, is_deleted = 1 WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);
}



// CRUD Commentaires

function createComments($message, $id)
{
	$pdo = DBConnect();

	$sql = "INSERT INTO comments (`message`, created_by, `user_id`, topic_id) VALUES (?, ?, ?, ?)";

	$sessionUser = $_SESSION["user"];

	$user = $sessionUser["id"];

	$statement = $pdo->prepare($sql);

	$statement->execute([$message, $user, $user, $id]);

	// header("Location: ./read_topic.php?id=$id");
}

function updateComments($message, $id)
{
	$pdo = DBConnect();

	$sessionUser = $_SESSION["user"];

	$user = $sessionUser["id"];

	date_default_timezone_set("Europe/Brussels");

	$date = date("Y-m-d H:i:s");

	$sql = "UPDATE comments SET message = ?, status = 'U', updated_at = ?, updated_by = ?
			WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$message, $date, $user, $id]);

	header("Location: ./comment.php");
}

function deleteComment($id)
{
	$pdo = DBConnect();

	$sql = "UPDATE comments SET status = 'D' ,is_active = 0, is_deleted = 1
		WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);
}



// CRUD Catégories

function createCategory($category, $description)
{
	$image = $_FILES["image"];

	$imageName = $image["name"];

	move_uploaded_file($image["tmp_name"], '../uploads/' . $imageName);

	$pdo = DBConnect();

	$sessionUser = $_SESSION["user"];

	$user = $sessionUser["id"];

	$sql = "INSERT INTO categories (category, `image`, `description`, created_by) VALUES (?, ?, ?, ?)";

	$statement = $pdo->prepare($sql);

	$statement->execute([$category, $imageName, $description, $user]);

	$images = $statement->fetchAll(PDO::FETCH_ASSOC);

	header("Location: ../categories/c_category.php");
}

function showCategory()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM categories";

	$statement = $pdo->query($sql);

	$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $categories;
}

function showCategoryByTopics($limit_category)
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM categories WHERE id = ?";

	$statement = $pdo->prepare($sql);

	
	$statement->execute([$limit_category]);
	$categories = $statement->fetch(PDO::FETCH_ASSOC);

	return $categories;
}

function updateCategory($category, $description, $id)
{
	$pdo = DBConnect();

	$sessionUser = $_SESSION["user"];

	$user = $sessionUser["id"];

	date_default_timezone_set("Europe/Brussels");

	$date = date("Y-m-d H:i:s");

	$sql = "UPDATE categories SET category = ?, `image` = ?, `description` = ?, `status` = 'U', updated_at = ?, updated_by = ?
			WHERE id = ?";

	$image = $_FILES["image"];

	$imageName = $image["name"];

	move_uploaded_file($image["tmp_name"], '../uploads/' . $imageName);

	$statement = $pdo->prepare($sql);

	$statement->execute([$category, $imageName, $description, $date, $user, $id]);

	header("Location: ../categories/c_category.php");
}

function deleteCategory($id)
{

	$pdo = DBConnect();

	$sql = "UPDATE categories SET status = 'D', is_active = 0, is_deleted = 1
		WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);
}

function restoreCategory($id)
{

	$pdo = DBConnect();

	$sql = "UPDATE categories SET status = 'R', is_active = 1, is_deleted = 0
		WHERE id = ?";

	$statement = $pdo->prepare($sql);

	$statement->execute([$id]);
}
function getUserRole()
{
	if (isset($_SESSION["user"])) {
		$pdo = DBConnect();
		$sql = "SELECT * FROM roles WHERE id = ?";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION["user"]["role_id"]]);
		$role_name = $stmt->fetch(PDO::FETCH_ASSOC);
		return $role_name;
	}
}

function getSpecificUserRole($id)
{
	$pdo = DBConnect();
	$sql = "SELECT * FROM roles WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$id]);
	$role_name = $stmt->fetch(PDO::FETCH_ASSOC);
	return $role_name;
}

function getUserFromUsername()
{

	$pdo = DBConnect();
	$sql = "SELECT username FROM users WHERE username = '?'";
	$stmt = $pdo->query($sql);
	$users = $stmt->fetch(PDO::FETCH_ASSOC);
	return $users;
}

function getEmailFromUsers()
{
	$pdo = DBConnect();
	$sql = "SELECT email FROM users";
	$stmt = $pdo->query($sql);
	$email = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $email;
}

function categoryData()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM categories WHERE id = ?";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([$_GET["id"]]);

	$categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

	return $categoryData;
}


function searchCategory($search)
{

	$pdo = DBConnect();
	$sql = "SELECT * FROM categories WHERE category  LIKE '%$search%'";
	$stmt = $pdo->query($sql);
	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $categories;
}

function searchTitle($search)
{

	$pdo = DBConnect();
	$sql = "SELECT * FROM topics WHERE title LIKE '%$search%'";
	$stmt = $pdo->query($sql);
	$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $topics;
}

function searchUsers($search) {
	$pdo = DBConnect();

	$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
	$stmt->execute([$search]);
	$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $users;
}
function categoryDesc()
{
	$pdo = DBConnect();
	$sql = "SELECT * FROM categories ORDER BY created_at DESC";
	$stmt = $pdo->query($sql);
	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $categories;
}

function topicLimit()
{
	$pdo = DBConnect();
	$sql = "SELECT * FROM topics order by created_at DESC limit 10";
	$stmt = $pdo->query($sql);
	$limit_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $limit_categories;
}

function lastComment($topic)
{
	$pdo = DBConnect();
	$sql = "SELECT users.username AS 'username', comments.created_at AS 'date' FROM comments
	INNER JOIN users
   ON comments.user_id = users.id
   WHERE comments.topic_id = ?
   ORDER BY comments.id DESC LIMIT 1";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$topic["id"]]);
	$users_last_comment = $stmt->fetch(PDO::FETCH_ASSOC);
	return $users_last_comment;
}

function countComment($topic)
{
	$pdo = DBConnect();
	$sql = "SELECT COUNT(id) FROM comments WHERE comments.topic_id = ? AND is_deleted = 0 AND is_active = 1";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$topic["id"]]);
	$topics_comments = $stmt->fetchColumn();
	return $topics_comments;
}

function topicFromId()
{
	$pdo = DBConnect();
	$sql = "SELECT * FROM topics WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_GET["id"]]);
	$topic = $stmt->fetch(PDO::FETCH_ASSOC);
	return $topic;
}

function topicFromIdGetTopic()
{
	$pdo = DBConnect();
	$sql = "SELECT * FROM topics WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_GET["topic_id"]]);
	$topic = $stmt->fetch(PDO::FETCH_ASSOC);
	return $topic;
}

function userData($topic)
{
	$pdo = DBConnect();
	$sql = "SELECT * FROM users WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$topic]);
	$usersData = $stmt->fetch(PDO::FETCH_ASSOC);
	return $usersData;
}

function comments()
{
	$pdo = DBConnect();
	$sql = "SELECT comments.id AS 'commentId', comments.message as 'message', comments.user_id AS 'commentUser', comments.is_active AS 'is_active', comments.is_deleted AS 'is_deleted', users.username as 'username', users.profile_picture as 'pp', users.id AS 'userId' FROM comments INNER JOIN users ON comments.user_id = users.id
 WHERE topic_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_GET["id"]]);
	$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $comments;
}

function selectCommentById()
{
	$pdo = DBConnect();
	$sql = "SELECT * FROM comments WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$_GET["comment_id"]]);
	$comment = $stmt->fetch(PDO::FETCH_ASSOC);
	return $comment;
}

function selectTopicsById()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM topics WHERE id = ?";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([$_GET["category_id"]]);

	$topicsData = $stmt->fetch(PDO::FETCH_ASSOC);

	return $topicsData;
}

function searchTopics($search)
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM topics WHERE title  LIKE '%$search%'";

	$stmt = $pdo->query($sql);

	$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$pdo = DBConnect();

	return $topics;
}

function userLastComment($topic)
{
	$pdo = DBConnect();

	$sql = "SELECT users.username AS 'username', comments.created_at AS 'date' FROM comments
INNER JOIN users
ON comments.user_id = users.id
WHERE comments.topic_id = ?
ORDER BY comments.id DESC LIMIT 1";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([$topic["id"]]);

	$users_last_comment = $stmt->fetch(PDO::FETCH_ASSOC);

	return $users_last_comment;
}

function topicsComments($topic)
{
	$pdo = DBConnect();

	$sql = "SELECT COUNT(id) FROM comments WHERE comments.topic_id = ?";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([$topic["id"]]);

	$topics_comments = $stmt->fetchColumn();

	return $topics_comments;
}

function searchTopicByCategory()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM topics WHERE category_id = ? ORDER BY id DESC";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([$_GET["id"]]);

	$topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $topics;
}

function roles()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM roles";

	$statement = $pdo->query($sql);

	$roles = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $roles;
}

function setRole($role, $submit)
{

	$pdo = DBConnect();

	$sql = "UPDATE users SET role_id = ? WHERE id = ?";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([$role, $submit]);
}

function selectRolesById()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM roles WHERE id = ?";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([$_POST["role"]]);

	$role = $stmt->fetch(PDO::FETCH_ASSOC);

	return $role;
}

function selectUserById()
{
	$pdo = DBConnect();

	$sql = "SELECT * FROM users WHERE id = ?";

	$stmt = $pdo->prepare($sql);

	$stmt->execute([$_POST["username"]]);

	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	return $user;
}
