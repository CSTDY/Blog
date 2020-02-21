<?php 
// Post variables
$post_id = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$post_slug = "";
$body = "";
$featured_image = "";
$post_topic = "";

/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/
// get all posts from DB
function getAllPosts()
{
	global $connection;
	
	// Admin can view all posts
	// Author can only view their posts
	if((isset($_SESSION['zalogowany_admin'])) && ($_SESSION['zalogowany_admin'])) {
		$sql = "SELECT * FROM artykuly";
	} elseif ((isset($_SESSION['zalogowany_autor'])) && ($_SESSION['zalogowany_autor'])) {
		$user_id = $_SESSION['autor-id'];
		$sql = "SELECT * FROM artykuly WHERE uzytkownik_id=$user_id";
	}
	$result = mysqli_query($connection, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $Article) {
		$Article['autor'] = getPostAuthorById($Article['uzytkownik_id']);
		array_push($final_posts, $Article);
	}
	return $final_posts;
}
// get the author/username of a post
function getPostAuthorById($user_id)
{
	global $connection;
	$sql = "SELECT uzytkownik FROM uzytkownicy WHERE id=$user_id";
	$result = mysqli_query($connection, $sql);
	if ($result) {
		// return username
		return mysqli_fetch_assoc($result)['uzytkownik'];
	} else {
		return null;
	}
}

/* - - - - - - - - - - 
-  Post actions
- - - - - - - - - - -*/
// if user clicks the create post button
if (isset($_POST['create_post'])) { createPost($_POST); }
// if user clicks the Edit post button
if (isset($_GET['edit-post'])) {
	$isEditingPost = true;
	$post_id = $_GET['edit-post'];
	editPost($post_id);
}
// if user clicks the update post button
if (isset($_POST['update_post'])) {
	updatePost($_POST);
}
// if user clicks the Delete post button
if (isset($_GET['delete-post'])) {
	$post_id = $_GET['delete-post'];
	deletePost($post_id);
}

/* - - - - - - - - - - 
-  Post functions
- - - - - - - - - - -*/
function createPost($request_values)
	{
		global $connection, $errors, $title, $featured_image, $topic_id, $body, $published;
		$title = esc($request_values['title']);
		$body = htmlentities(esc($request_values['body']));
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
		}
		if (isset($request_values['publish'])) {
			$published = esc($request_values['publish']);
		}
		// create slug: if title is "The Storm Is Over", return "the-storm-is-over" as slug
		$post_slug = makeSlug($title);
		// validate form
		if (empty($title)) { array_push($errors, "Tytuł artykułu jest wymagany!"); }
		if (empty($body)) { array_push($errors, "Treść artykułu jest wymagana!"); }
		if (empty($topic_id)) { array_push($errors, "Wybór sekcji jest wymagany!"); }
		// Get image name
	  	$featured_image = $_FILES['featured_image']['name'];
	  	if (empty($featured_image)) { array_push($errors, "Zdjęcie do artykułu jest wymagane!"); }
	  	// image file directory
	  	$target = "../static/obrazy/" . basename($featured_image);
	  	if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
	  		array_push($errors, "Nie udało się załadować zdjęcia! Sprawdź ustawienia serwera!");
	  	}
		// Ensure that no post is saved twice. 
		$post_check_query = "SELECT * FROM artykuly WHERE slug='$post_slug' LIMIT 1";
		$result = mysqli_query($connection, $post_check_query);

		if (mysqli_num_rows($result) > 0) { // if post exists
			array_push($errors, "Już istnieje artykuł z takim tytułem!");
		}
		// create post if there are no errors in the form
		if (count($errors) == 0) {
			if(isset($_SESSION['zalogowany_admin']) && $_SESSION['zalogowany_admin']){
			$query = "INSERT INTO artykuly (uzytkownik_id, tytul, slug, image, body, published, created_at, updated_at) 
			VALUES(".$_SESSION['admin_id'].", '$title', '$post_slug', '$featured_image', '$body', $published, now(), now())";
			}
			if(isset($_SESSION['zalogowany_autor']) && $_SESSION['zalogowany_autor']) {
				$query = "INSERT INTO artykuly (uzytkownik_id, tytul, slug, image, body, published, created_at, updated_at) 
			    VALUES(".$_SESSION['admin_id'].", '$title', '$post_slug', '$featured_image', '$body', $published, now(), now())";
			}
			if(mysqli_query($connection, $query)){ // if post created successfully
				$inserted_post_id = mysqli_insert_id($connection);
				// create relationship between post and topic
				$sql = "INSERT INTO artykuly_tytuly (artykul_id, tytul_id) VALUES($inserted_post_id, $topic_id)";
				mysqli_query($connection, $sql);

				$_SESSION['wiadomosc'] = "Artykuł utworzony pomyślnie!";
				header('location: artykuly.php');
				exit(0);
			}
		}
	}

	/* * * * * * * * * * * * * * * * * * * * *
	* - Takes post id as parameter
	* - Fetches the post from database
	* - sets post fields on form for editing
	* * * * * * * * * * * * * * * * * * * * * */
	function editPost($role_id)
	{
		global $connection, $title, $post_slug, $body, $published, $isEditingPost, $post_id;
		$sql = "SELECT * FROM artykuly WHERE id=$role_id LIMIT 1";
		$result = mysqli_query($connection, $sql);
		$Article = mysqli_fetch_assoc($result);
		// set form values on the form to be updated
		$title = $Article['tytul'];
		$body = $Article['body'];
		$published = $Article['published'];
	}

	function updatePost($request_values)
	{
		global $connection, $errors, $post_id, $title, $featured_image, $topic_id, $body, $published;

		$title = esc($request_values['title']);
		$post_id = esc($request_values['post_id']);
		$body = htmlentities(esc($request_values['body']));
		if (isset($request_values['topic_id'])) {
			$topic_id = esc($request_values['topic_id']);
		}
		// create slug: if title is "The Storm Is Over", return "the-storm-is-over" as slug
		$post_slug = makeSlug($title);

		if (empty($title)) { array_push($errors, "Tytuł artykułu jest wymagany!"); }
		if (empty($body)) { array_push($errors, "Treść artykułu jest wymagana!"); }
		// if new featured image has been provided
		// Get image name
		$featured_image = $_FILES['featured_image']['name'];
		if (empty($featured_image)) { array_push($errors, "Zdjęcie do artykułu jest wymagane!"); }
		// image file directory
		$target = "../static/obrazy/" . basename($featured_image);
		if (!move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
			array_push($errors, "Nie udało się załadować zdjęcia! Sprawdź ustawienia serwera!");
		}
		
		if (isset($request_values['publish'])) {
			$published = esc($request_values['publish']);
		}

		// register topic if there are no errors in the form
		if (count($errors) == 0) {
			$query = "UPDATE artykuly SET tytul='$title', slug='$post_slug', views=0, image='$featured_image', body='$body', published=$published, updated_at=now() WHERE id=$post_id";
			// attach topic to post on post_topic table
			if(mysqli_query($connection, $query)){ // if post created successfully
				if (isset($topic_id)) {
					$inserted_post_id = mysqli_insert_id($connection);
					// create relationship between post and topic
					$sql = "INSERT INTO artykuly_tytuly (artykul_id, tytul_id) VALUES($inserted_post_id, $topic_id)";
					mysqli_query($connection, $sql);
					$_SESSION['wiadomosc'] = "Edycja artykułu przebiegła pomyślnie!";
					header('location: artykuly.php');
					exit(0);
				}
			}
			$_SESSION['wiadomosc'] = "Edycja artykułu przebiegła pomyślnie!";
			header('location: artykuly.php');
			exit(0);
		}
	}
	// delete blog post
	function deletePost($post_id)
	{
		global $connection;
		$sql = "DELETE FROM artykuly WHERE id=$post_id";
		if (mysqli_query($connection, $sql)) {
			$_SESSION['wiadomosc'] = "Usunięto artykuł!";
			header("location: artykuly.php");
			exit(0);
		}
	}

	// if user clicks the publish post button
if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
	$message = "";
	if (isset($_GET['publish'])) {
		$message = "Artykuł pomyślnie udostępniony!";
		$post_id = $_GET['publish'];
	} else if (isset($_GET['unpublish'])) {
		$message = "Artykuł pomyślnie zablokowany!";
		$post_id = $_GET['unpublish'];
	}
	togglePublishPost($post_id, $message);
}
// delete blog post
function togglePublishPost($post_id, $message)
{
	global $connection;
	$sql = "UPDATE artykuly SET published=!published WHERE id=$post_id";
	
	if (mysqli_query($connection, $sql)) {
		$_SESSION['wiadomosc'] = $message;
		header("location: artykuly.php");
		exit(0);
	}
}
?>