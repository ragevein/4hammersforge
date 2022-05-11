

	</div>

</div>
  <div id="bottom">
	<div class="footer">
    	<div class="bot-nav">
        	<div class="bot-nav-item"><a href="index.php">Castle</a></div>
        	<div class="bot-nav-item"><a href="#">Tavern</a></div>
       		<?php 
        	if (isset($_SESSION['login'])){
           		echo  '<div class="bot-nav-item"><a href="index.php?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].'">Profile</a></div>';
        	}
        	?>
        	<div class="bot-nav-item"><a href="index.php?mainaction=calendar">Almanac</a></div>
        	<?php 
        	if ($_SESSION['u_id'] == 1){
          		echo '<div class="bot-nav-item"><a href="index.php?/admin/index.php">Lord</a></div>';
        	}
        	echo '
        </div>
    	<div class="bot-nav">© 2022 4 HammersForge ALL RIGHTS RESERVED admin@4hammersforge.com</div>
    	<div class="bot-nav"> ~~ Best viewed with Chrome or Firefox ~~ Your IP '.rtrim($ip).'</div>';
		?>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 83 92" id="logo"><defs></defs><g id="a"><path d="M53.5,2s0,4-6,9V30h-12V13S26.5,10,26.5,0C21,19.5,0,31.5,0,31.5c0,0,7,1,7,15,14-16,19-4,19-4,0,0,3.5,5.5-5.5,20.5,5.81-.07,11.33,2.5,15,7v-29.26h12v26.26c8-9,15-8,15-8,0,0,0,2.11-3-7.44s-2.5-15.06,0-17.19,8.46-3.87,12,4.13c0,0,5.46-8,3.46-12s-16.46-.5-16.46-.5c-1.81-4.58-1.44-9.73,1-14,14.5-2.5,16.5,6.5,16.5,6.5,0,0,2-13,7-15,0,0-23.5,2.5-29.5-1.5ZM28.5,28c-4-2-11,0-11,0,4.03-3.36,7.42-7.43,10-12,1.2,3.88,1.55,7.97,1,12Z"/></g><g id="b"><path class="c" d="M13.5,75c10.06,1.99,18.79,8.17,24,17,0,0-1-11,0-16-5-13-19-12-19-12l-5,11Z"/><path class="c" d="M75.5,69.42s-20.52,4.16-29.52,19.16c0,0,1-11,0-16,5-13,19.52-13.16,19.52-13.16l10,10Z"/></g></svg>
  	</div>
  </div> 
</div>
</body>
<script src="main.js"></script>
</html>
