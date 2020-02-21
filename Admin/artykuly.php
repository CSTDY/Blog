<?php  require_once('../config.php'); ?>
<?php  require_once(ROOT_PATH . '/admin/includes/admin_function.php'); ?>
<?php  require_once(ROOT_PATH . '/admin/includes/post_function.php'); ?>
<?php require_once(ROOT_PATH . '/admin/includes/head_section.php'); ?>

<!-- Get all admin posts from DB -->
<?php $posts = getAllPosts(); ?>
	<title>Admin | Manage Posts</title>
</head>
<body>
	<!-- admin navbar -->
	<?php require_once(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php require_once(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Display records from DB-->
		<div class="table-div"  style="width: 80%;">
			<!-- Display notification message -->
			<?php require_once(ROOT_PATH . '/Admin/Includes/wiadomosci.php') ?>

			<?php if (empty($posts)): ?>
				<h1 style="text-align: center; margin-top: 20px;">Brak artykułów w bazie...</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th>N</th>
						<th>Title</th>
						<th>Author</th>
						<th>Views</th>
						<!-- Only Admin can publish/unpublish post -->
						<?php if ((isset($_SESSION['zalogowany_admin'])) && ($_SESSION['zalogowany_admin'])): ?>
							<th><small>Publish</small></th>
						<?php endif ?>
						<th><small>Edit</small></th>
						<th><small>Delete</small></th>
					</thead>
					<tbody>
					<?php foreach ($posts as $key => $Article): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<a 	target="_blank"
								href="<?php echo BASE_URL . '\pojedynczy_artykul.php?Article-slug=' . $Article['slug'] ?>">
									<?php echo $Article['tytul']; ?>	
								</a>
							</td>
							<td><?php echo $Article['autor']; ?></td>
							<td><?php echo $Article['views']; ?></td>
							
							<!-- Only Admin can publish/unpublish post -->
							<?php if ((isset($_SESSION['zalogowany_admin'])) && ($_SESSION['zalogowany_admin'])): ?>
								<td>
								<?php if ($Article['published'] == true): ?>
									<a class="fa fa-check btn unpublish"
										href="artykuly.php?unpublish=<?php echo $Article['id'] ?>">
									</a>
								<?php else: ?>
									<a class="fa fa-times btn publish"
										href="artykuly.php?publish=<?php echo $Article['id'] ?>">
									</a>
								<?php endif ?>
								</td>
							<?php endif ?>

							<td>
								<a class="fa fa-pencil btn edit"
									href="zrob_artykul.php?edit-post=<?php echo $Article['id'] ?>">
								</a>
							</td>
							<td>
								<a  class="fa fa-trash btn delete" 
									href="zrob_artykul.php?delete-post=<?php echo $Article['id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>
</html>