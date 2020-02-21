<?php 
    $tematy = getAllTopics();
    $sqlcode = "SELECT id FROM tytuly ORDER BY id DESC LIMIT 1";
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <!-- Google Fonts -->
	    <link href="https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Noto+Serif|Tangerine" rel="stylesheet">
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        