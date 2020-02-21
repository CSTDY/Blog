<?php
/**Pobiera wszystkie udostępnione artykuły */

function getPublishedArticles() {
    
    global $connection;
    $sql = "SELECT * FROM artykuly WHERE published=true";
    $wyniki = mysqli_query($connection, $sql);
    
    $artykuly = mysqli_fetch_all($wyniki, MYSQLI_ASSOC);
    $final_artykuly = array();
	foreach ($artykuly as $artykul) {
		$artykul['temat'] = getPostTopic($artykul['id']); 
		array_push($final_artykuly, $artykul);
	}
	return $final_artykuly;
} 

/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
function getPostTopic($artykul_id){
	global $connection;
	$sql = "SELECT * FROM tytuly WHERE id=
			(SELECT tytul_id FROM artykuly_tytuly WHERE artykul_id=$artykul_id) LIMIT 1";
	$wyniki = mysqli_query($connection, $sql);
	$tytul = mysqli_fetch_assoc($wyniki);
	return $tytul;
}

/* * * * * * * * * * * * * * * *
* Returns all posts under a topic
* * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($tytul_id) {
	global $connection;
	$sql = "SELECT * FROM artykuly 
			WHERE id= 
			(SELECT artykul_id FROM artykuly_tytuly 
				WHERE tytul_id=$tytul_id GROUP BY artykul_id 
				HAVING COUNT(1) = 1)";
	$wyniki = mysqli_query($connection, $sql);
	// fetch all posts as an associative array called $artykuly
	$artykuly = mysqli_fetch_all($wyniki, MYSQLI_ASSOC);

	$final_artykuly = array();
	foreach ($artykuly as $artykul) {
		$artykul['temat'] = getPostTopic($artykul['id']); 
		array_push($final_artykuly, $artykul);
	}
	return $final_artykuly;
}
/* * * * * * * * * * * * * * * *
* Returns topic name by topic id
* * * * * * * * * * * * * * * * */
function getTopicNameById($id)
{
	global $connection;
	$sql = "SELECT nazwa FROM tytuly WHERE id=$id";
	$wyniki = mysqli_query($connection, $sql);
	$temat = mysqli_fetch_assoc($wyniki);
	return $temat['nazwa'];
}

/* * * * * * * * * * * * * * *
* Returns a single post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $connection;
	// Get single Article slug
	$artykul_slug = $_GET['Article-slug'];
	$sql = "SELECT * FROM artykuly WHERE slug='$artykul_slug' AND published=true";
	$wyniki = mysqli_query($connection, $sql);

	// fetch query results as associative array.
	$artykul = mysqli_fetch_assoc($wyniki);
	if ($artykul) {
		// get the topic to which this post belongs
		$artykul['temat'] = getPostTopic($artykul['id']);
	}
	return $artykul;
}
/* * * * * * * * * * * *
*  Returns all topics
* * * * * * * * * * * * */
function getAllTopics()
{
	global $connection;
	$sql = "SELECT * FROM tytuly";
	$wyniki = mysqli_query($connection, $sql);
	$tematy = mysqli_fetch_all($wyniki, MYSQLI_ASSOC);
	return $tematy;
}

?>