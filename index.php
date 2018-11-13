<?php
include 'top.html';

session_start();
?>
  <br />
  <br />
  <div class="container" style = "position:relative;">
	<form action=“”>
		<div>
			<h3>What is the right shortcut for the word 'Something'?</h3>
  <div class="input-field col s12">
    <select>
      <option value="" disabled selected>Choose your option</option>
      <option value="1">Option 1</option>
      <option value="2">Option 2</option>
      <option value="3">Option 3</option>
    </select>
    <label>Materialize Select</label>
  </div>
		    <label><input type="radio" name="ans" value="ch1" /><span><h5>stm</h5></span></label>  
			<label><input type="radio" name="ans" value="ch2" /><span><h5>smt</h5></span></label> 
			<label><input type="radio" name="ans" value="ch3" /><span><h5>smth</h5></span></label>  
		</div>
	</form>
  </div>
  <br />
  <br />


<?php



session_destroy();
include 'bottom.html';
?>
