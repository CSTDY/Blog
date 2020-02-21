<?php if (isset($_SESSION['wiadomosc'])) : ?>
      <div class="message" >
      	<p>
          <?php 
          	echo $_SESSION['wiadomosc']; 
          	unset($_SESSION['wiadomosc']);
          ?>
      	</p>
      </div>
<?php endif ?>