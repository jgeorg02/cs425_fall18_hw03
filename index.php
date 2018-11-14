<?php
include 'top.html';
include 'auxiliary.php';

session_start();
?>

  <script> 
  document.getElementById('home_page').classList.add('active');
  </script>
  <br />
  <br />
  <div class="container" style = "position:relative;">
	<form action=“”>
		<div>
			<h3>What is the right shortcut for the word 'Something'?</h3>
		    <label><input type="radio" name="ans" value="ch1" /><span><h5>stm</h5></span></label>  
			<label><input type="radio" name="ans" value="ch2" /><span><h5>smt</h5></span></label> 
			<label><input type="radio" name="ans" value="ch3" /><span><h5>smth</h5></span></label>  
		</div>
    <button id="next">Next</button>
	</form>
  </div>
  <br />
  <br />

<?php
session_destroy();
include 'bottom.html';
?>
