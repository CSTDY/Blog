<?php  require_once('../config.php'); ?>
<?php  require_once(ROOT_PATH . '/admin/includes/admin_function.php'); ?>
<?php 
	// Get all admin users from DB
	$admins = getAdminUsers();
	$role = ['Admin', 'Autor'];				
?>
<?php require_once(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Zarządzaj użytkownikami</title>
</head>
<body>
	<!-- admin navbar -->
	<?php require_once(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- Left side menu -->
		<?php require_once(ROOT_PATH . '/admin/includes/menu.php') ?>
		<!-- Middle form - to create and edit  -->
		<div class="action">
			<h1 class="page-title">Dodaj/Edytuj Admina</h1>

			<form method="post" action="<?php echo BASE_URL . '/Admin/uzytkownicy.php'; ?>" >

				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="password" name="passwordConfirmation" placeholder="Password confirmation">
				<select name="rola">
					<option value="" selected disabled>Przydziel rolę</option>
					<?php foreach ($role as $key => $rola): ?>
						<option value="<?php echo $rola; ?>"><?php echo $rola; ?></option>
					<?php endforeach ?>
				</select>

				<!-- if editing user, display the update button instead of create button -->
				<?php if ($isEditingUser === true): ?> 
					<button type="submit" class="btn" name="update_admin">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_admin">Zapisz użytkownika</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div">
			<!-- Display notification message -->
			<?php require_once(ROOT_PATH . '/Admin/Includes/wiadomosci.php') ?>

			<?php if (empty($admins)): ?>
				<h1>Nie znaleziono adminów w bazie.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Admin</th>
						<th>Rola</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($admins as $key => $admin): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<?php echo $admin['uzytkownik']; ?>, &nbsp;
								<?php echo $admin['email']; ?>	
							</td>
							<td><?php echo $admin['rola']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="uzytkownicy.php?edit-admin=<?php echo $admin['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete" 
								    href="uzytkownicy.php?delete-admin=<?php echo $admin['id'] ?>">
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