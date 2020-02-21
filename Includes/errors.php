<!-- TO PRAWDOPODOBNIE NIE DZIAŁA BO W SYSTEMIE REJESTRACJI NIE MA ZLICZANIA ERRORÓW -->
<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>