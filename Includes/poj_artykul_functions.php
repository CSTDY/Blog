<?php

//WYJMUJĘ WSZYSTKIE KOMENTARZE Z BAZY
$pytanie = "SELECT * FROM komentarze WHERE artykul_id =".$Article['id'];
$wynik = mysqli_query($connection, $pytanie);
$comments = mysqli_fetch_all($wynik, MYSQLI_ASSOC);

//COUNT ALL COMMENTS

function countComments($Artykul_id) {
    global $connection;
	$sql = "SELECT COUNT(*) AS total FROM komentarze AS kom, artykuly AS art WHERE kom.id IS NOT NULL AND 
    art.id = '$Artykul_id' AND kom.artykul_id = art.id";
	$wynik = mysqli_query($connection, $sql);
	$data = mysqli_fetch_assoc($wynik);
	echo $data['total'];
}

//POBRANIE AUTORA KOMENTARZA Z BAZY

function getCommentUser($Komentarz_id) {
    global $connection;
    $sql = "SELECT user.uzytkownik AS user FROM uzytkownicy AS user, komentarze AS kom WHERE kom.uzytkownik_id = user.id
    AND kom.id = '$Komentarz_id' LIMIT 1";
    $wynik = mysqli_query($connection, $sql);
    $data = mysqli_fetch_assoc($wynik);
    echo $data['user'];
}

//POBIERANIE ODPOWIEDZI NA KOMENTARZE

function Replies($Komentarz_id) {
    global $connection;
    $sql = "SELECT * FROM odp_na_komentarze WHERE komentarz_id = '$Komentarz_id'";
    $wynik = mysqli_query($connection, $sql);
    $Odpowiedzi = mysqli_fetch_all($wynik, MYSQLI_ASSOC);
    return $Odpowiedzi;
}

//POBRANIE AUTORA ODPOWIEDZI NA KOMENTARZ

function getRepliesUser($User_id) {
    global $connection;
    $sql = "SELECT users.uzytkownik AS user FROM uzytkownicy AS users, odp_na_komentarze AS odp WHERE 
    users.id = odp.uzytkownik_id AND users.id = '$User_id' LIMIT 1";
    $wynik = mysqli_query($connection, $sql);
    $data = mysqli_fetch_assoc($wynik);
    echo $data['user'];
}

// If the user clicked submit on comment form...
if (isset($_POST['comment_posted'])) {
	global $connection;
	// grab the comment that was submitted through Ajax call
	$comment_text = $_POST['comment_text'];
	// insert comment into database
	$sql = "INSERT INTO komentarze(id, uzytkownik_id, artykul_id, body, created_at, updated_at) VALUES 
    (NULL,".$_SESSION['user'].", ".$Article['id'].", '$comment_text', now(), NULL)";
	$wynik = mysqli_query($connection, $sql);
	// Query same comment from database to send back to be displayed
	$inserted_id = $connection->insert_id;
	$res = mysqli_query($connection, "SELECT * FROM komentarze WHERE id=$inserted_id");
	$inserted_comment = mysqli_fetch_assoc($res);
	// if insert was successful, get that same comment from the database and return it
	if ($wynik) {
		$inserted_comment = "<div class='comment clearfix'>
                    <div class='comment-details'>
                        <span class='comment-name'>". getCommentUser($inserted_comment['id'])."</span>
                        <span class='comment-date'>". $inserted_comment['created_at']."</span>
                        <p>". $inserted_comment['body']."</p>
                        <a class='reply-btn' href='#' data-id='".$inserted_comment['id']."'>reply</a>
                    </div>
                    <!-- reply form -->
                    <form action='post_details.php' class='reply_form clearfix' id='comment_reply_form_".$inserted_comment['id']."' data-id='".$inserted_comment['id']."'>
                        <textarea class='form-control' name='reply_text' id='reply_text' cols='30' rows='2'></textarea>
                        <button class='btn btn-primary btn-xs pull-right submit-reply'>Submit reply</button>
                    </form>
                </div>";
		$comment_info = array(
			'comment' => $comment
		);
		echo json_encode($comment_info);
		exit();
	} else {
		echo "error";
		exit();
	}
}
// If the user clicked submit on reply form...
if (isset($_POST['reply_posted'])) {
	global $connection;
	// grab the reply that was submitted through Ajax call
	$reply_text = $_POST['reply_text']; 
	$comment_id = $_POST['comment_id']; 
	// insert reply into database
    $sql = "INSERT INTO odp_na_komentarze(id, uzytkownik_id, komentarz_id, body, created_at, updated_at) VALUES 
    (NULL, ".$_SESSION['user'].", '$comment_id', '$reply_text', now(), NULL)";
	$wynik = mysqli_query($connection, $sql);
	$inserted_id = $connection->insert_id;
	$res = mysqli_query($connection, "SELECT * FROM odp_na_komentarze WHERE id=$inserted_id");
	$inserted_reply = mysqli_fetch_assoc($res);
	// if insert was successful, get that same reply from the database and return it
	if ($wynik) {
		$reply = "<div class='comment reply clearfix'>
                <div class='comment-details'>
                    <span class='comment-name'>". getRepliesUser($reply['uzytkownik_id']). "</span>
                    <span class='comment-date'>". $reply['created_at']."</span>
                    <p>". $reply['body']. "</p>
                    <a class='reply-btn' href='#'>reply</a>
                </div>
            </div>";
		echo $reply;
		exit();
	} else {
		echo "error";
		exit();
	}
}

?>