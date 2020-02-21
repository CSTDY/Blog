
<h2><span id="comments_count"><?php countComments($Article['id']); ?></span> Comment(s)</h2>
	<hr>
	<?php if(isset($comments)) : ?>

	<?php foreach ($comments as $comment) : ?>
	<!-- comments wrapper -->
	<div id="comments-wrapper">
		<div class="comment clearfix">
			<div class="comment-details">
				<span class="comment-name"><?php getCommentUser($comment['id']); ?></span>
				<span class="comment-date"><?php echo $comment['created_at']; ?></span>
				<p><?php echo $comment['body']; ?></p>
				<a class="reply-btn" href="#" data-id="<?php echo $comment['id']; ?>">Dodaj komentarz</a>
			</div>
			<!-- reply form -->
			<form action="post_details.php" class="reply_form clearfix" id="comment_reply_form_<?php echo $comment['id'] ?>" data-id="<?php echo $comment['id']; ?>">
				<textarea class="form-control" name="reply_text" id="reply_text" cols="30" rows="2"></textarea>
				<button class="btn btn-primary btn-xs pull-right submit-reply">Odpowiedz na komentarz</button>
			</form>
		</div>
		
		<?php $Replies = Replies($comment['id']); ?> 
		<div class="replies_wrapper_<?php echo $comment['id']; ?>">
			<?php if(isset($Replies)): ?>
				<?php foreach($Replies as $reply): ?>
				<!-- reply -->
				<div class="comment reply clearfix">
					<div class="comment-details">
						<span class="comment-name"><?php getRepliesUser($reply['uzytkownik_id']); ?></span>
						<span class="comment-date"><?php echo $reply['created_at']; ?></span>
						<p><?php echo $reply['body']; ?></p>
						<a class="reply-btn" href="#">odpowiedz</a>
					</div>
				</div>
				<?php endforeach ?>
			<?php endif ?>
		</div>
		<?php endforeach ?>
	<?php else: ?>
		<h2>Bądź pierwszy, który skomentuje ten post...</h2>
	<?php endif ?>
	<!-- COMMENT SECTION-->
	<?php if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'])): ?>
	<div class="col-md-6 col-md-offset-3 comments-section">
		<form class="clearfix" action="Pojedynczy_Artykul.php?Article-slug=<?php echo $Article['slug']; ?>" method="post" id="comment_form">
			<textarea class="form-control" name="comment_text" id="comment_text" placeholder="Wpisz komentarz"></textarea>
			<button class="col-md-6 col-md-offset-3 comments-section" id="submit_comment">Udostępnij komentarz</button>
		</form>
	</div>
<?php else: ?>
	<div class="well" style="margin-top: 20px;">
		<h4 class="text-center"><a href="index.php">Zaloguj się</a> żeby zamieścić komentarz</h4>
	</div>	
<?php endif ?>
</div>

<!-- // comments wrapper -->

