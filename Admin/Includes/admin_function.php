<?php 
// Admin user variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
// general variables
$errors = [];

// Topics variables
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";

/* - - - - - - - - - - 
-  Admin users actions
- - - - - - - - - - -*/
// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}
// if user clicks the Edit admin button
if (isset($_GET['edit-admin'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-admin'];
	editAdmin($admin_id);
}
// if user clicks the update admin button
if (isset($_POST['update_admin'])) {
	updateAdmin($_POST);
}
// if user clicks the Delete admin button
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	deleteAdmin($admin_id);
}


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Returns all admin users and their corresponding roles
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAdminUsers(){
	global $connection, $roles;
	$sql = "SELECT * FROM uzytkownicy WHERE rola IS NOT NULL";
	$wynik = mysqli_query($connection, $sql);
	$users = mysqli_fetch_all($wynik, MYSQLI_ASSOC);

	return $users;
}
/* * * * * * * * * * * * * * * * * * * * *
* - Escapes form submitted value, hence, preventing SQL injection
* * * * * * * * * * * * * * * * * * * * * */
function esc(String $value){
	// bring the global db connect object into function
	global $connection;
	// remove empty space sorrounding string
	$val = trim($value); 
	$val = mysqli_real_escape_string($connection, $value);
	return $val;
}
// Receives a string like 'Some Sample String'
// and returns 'some-sample-string'
function makeSlug(String $string){
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}

/* - - - - - - - - - - 
-  Topic actions
- - - - - - - - - - -*/
// if user clicks the create topic button
if (isset($_POST['create_topic'])) { createTopic($_POST); }
// if user clicks the Edit topic button
if (isset($_GET['edit-topic'])) {
	$isEditingTopic = true;
	$topic_id = $_GET['edit-topic'];
	editTopic($topic_id);
}
// if user clicks the update topic button
if (isset($_POST['update_topic'])) {
	updateTopic($_POST);
}
// if user clicks the Delete topic button
if (isset($_GET['delete-topic'])) {
	$topic_id = $_GET['delete-topic'];
	deleteTopic($topic_id);
}

/* - - - - - - - - - - - -
-  Admin users functions
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Receives new admin data from form
* - Create new admin user
* - Returns all admin users with their roles 
* * * * * * * * * * * * * * * * * * * * * * */
function createAdmin($request_values){
	global $connection, $errors, $role, $username, $email;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	if(isset($request_values['rola'])){
		$role = esc($request_values['rola']);
	}
	// form validation: ensure that the form is correctly filled
	if (empty($username)) { array_push($errors, "Wymagana nazwa użytkownika!"); }
	if (empty($email)) { array_push($errors, "Adres email jest wymagany!"); }
	if (empty($role)) { array_push($errors, "Wybór roli jest wymagany!");}
	if (empty($password)) { array_push($errors, "Hasło jest wymagane!"); }
	if ($password != $passwordConfirmation) { array_push($errors, "Hasła nie są identyczne!"); }
	// Ensure that no user is registered twice. 
	// the email and usernames should be unique
	$user_check_query = "SELECT * FROM uzytkownicy WHERE uzytkownik='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($connection, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	if ($user) { // if user exists
		if ($user['uzytkownik'] === $username) {
		  array_push($errors, "Już istnieje taki użytkownik!");
		}

		if ($user['email'] === $email) {
		  array_push($errors, "Adres email jesz jest w bazie!");
		}
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password);//encrypt the password before saving in the database
		$query = "INSERT INTO uzytkownicy (uzytkownik, email, rola, pass, created_at, updated_at) 
				  VALUES('$username', '$email', '$role', '$password', now(), now())";
		mysqli_query($connection, $query);

		$_SESSION['wiadomosc'] = "Rejestracja przebiegła pomyślnie!";
		header('location: uzytkownicy.php');
		exit(0);
	}
}

/* - - - - - - - - - - 
-  Topics functions
- - - - - - - - - - -*/
// get all topics from DB
function getAllTopics() {
	global $connection;
	$sql = "SELECT * FROM tytuly";
	$result = mysqli_query($connection, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}

function createTopic($request_values){
	global $connection, $errors, $topic_name;
	$topic_name = esc($request_values['topic_name']);
	// create slug: if topic is "Life Advice", return "life-advice" as slug
	$topic_slug = makeSlug($topic_name);
	// validate form
	if (empty($topic_name)) { 
		array_push($errors, "Wybór sekcji jest wymagana!"); 
	}
	// Ensure that no topic is saved twice. 
	$topic_check_query = "SELECT * FROM tytuly WHERE slug='$topic_slug' LIMIT 1";
	$result = mysqli_query($connection, $topic_check_query);
	if (mysqli_num_rows($result) > 0) { // if topic exists
		array_push($errors, "Sekcja już istnieje!");
	}
	// register topic if there are no errors in the form
	if (count($errors) == 0) {
		$query = "INSERT INTO tytuly (nazwa, slug) 
				  VALUES('$topic_name', '$topic_slug')";
		mysqli_query($connection, $query);

		$_SESSION['wiadomosc'] = "Pomyślnie utworzono nową sekcję!";
		header('location: tytuly.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Takes topic id as parameter
* - Fetches the topic from database
* - sets topic fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editTopic($topic_id) {
	global $connection, $topic_name, $isEditingTopic, $topic_id;
	$sql = "SELECT * FROM tytuly WHERE id=$topic_id LIMIT 1";
	$result = mysqli_query($connection, $sql);
	$topic = mysqli_fetch_assoc($result);
	// set form values ($topic_name) on the form to be updated
	$topic_name = $topic['nazwa'];
}
function updateTopic($request_values) {
	global $connection, $errors, $topic_name, $topic_id;
	$topic_name = esc($request_values['topic_name']);
	$topic_id = esc($request_values['topic_id']);
	// create slug: if topic is "Life Advice", return "life-advice" as slug
	$topic_slug = makeSlug($topic_name);
	// validate form
	if (empty($topic_name)) { 
		array_push($errors, "Nazwa tytułu sekcji jest wymagana!"); 
	}
	// register topic if there are no errors in the form
	if (count($errors) == 0) {
		$query = "UPDATE tytuly SET nazwa='$topic_name', slug='$topic_slug' WHERE id=$topic_id";
		mysqli_query($connection, $query);

		$_SESSION['wiadomosc'] = "Zmiana tytułu sekcji przebiegła pomyślnie!";
		header('location: tytuly.php');
		exit(0);
	}
}
// delete topic 
function deleteTopic($topic_id) {
	global $connection;
	$sql = "DELETE FROM tytuly WHERE id=$topic_id";
	if (mysqli_query($connection, $sql)) {
		$_SESSION['wiadomosc'] = "Topic successfully deleted";
		header("location: tytuly.php");
		exit(0);
	}
}

/* * * * * * * * * * * * * * * * * * * * *
* - Takes admin id as parameter
* - Fetches the admin from database
* - sets admin fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $connection, $username, $role, $isEditingUser, $admin_id, $email;

	$sql = "SELECT * FROM uzytkownicy WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($connection, $sql);
	$admin = mysqli_fetch_assoc($result);

	// set form values ($username and $email) on the form to be updated
	$username = $admin['uzytkownik'];
	$email = $admin['email'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Receives admin request from form and updates in database
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values){
	global $connection, $errors, $role, $username, $isEditingUser, $admin_id, $email;
	// get id of the admin to be updated
	$admin_id = $request_values['admin_id'];
	// set edit state to false
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if(isset($request_values['rola'])){
		$role = $request_values['rola'];
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		//encrypt the password (security purposes)
		$password = md5($password);

		$query = "UPDATE uzytkownicy SET uzytkownik='$username', email='$email', rola='$role', pass='$password' WHERE id=$admin_id";
		mysqli_query($connection, $query);

		$_SESSION['wiadomosc'] = "Admin user updated successfully";
		header('location: uzytkownicy.php');
		exit(0);
	}
}
// delete admin user 
function deleteAdmin($admin_id) {
	global $connection;
	$sql = "DELETE FROM uzytkownicy WHERE id=$admin_id";
	if (mysqli_query($connection, $sql)) {
		$_SESSION['wiadomosc'] = "Pomyślnie usunięto użytkownika";
		//restar autoinkrementacji
		$ilu_userow = "SELECT MAX('id') FROM uzytkownicy";
		mysqli_query($connection, $ilu_userow);
		$reset_autoincrement = "ALTER TABLE uzytkownicy AUTO_INCREMENT = '$ilu_userow' + 1";
		mysqli_query($connection, $reset_autoincrement);
		header("location: uzytkownicy.php");
		exit(0);

	}
}

//COUNT ALL USERS

function countUsers() {
	global $connection;
	$sql = "SELECT COUNT(*) as total FROM uzytkownicy WHERE id IS NOT NULL AND rola IS NULL";
	$wynik = mysqli_query($connection, $sql);
	$data = mysqli_fetch_assoc($wynik);
	echo $data['total'];
}

//COUNT ALL ARTICLES

function countArticles() {
	global $connection;
	$sql = "SELECT COUNT(*) as total FROM artykuly WHERE id IS NOT NULL";
	$wynik = mysqli_query($connection, $sql);
	$data = mysqli_fetch_assoc($wynik);
	echo $data['total'];
}

//COUNT ALL COMMENTS

function countComments() {
	global $connection;
	$sql = "SELECT COUNT(*) AS total FROM komentarze WHERE id IS NOT NULL";
	$wynik = mysqli_query($connection, $sql);
	$data = mysqli_fetch_assoc($wynik);
	echo $data['total'];
}
?>