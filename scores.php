<?php
include 'top.html';
session_start(); session_unset();
?>

<script>
    document.getElementById('scores_page').classList.add('active');
</script>

<!-- Back to top button -->
<a class="my-btn" href="scores.php">Top</a>
<!-- /Back to top button -->

<?php
include 'bottom.html';
$questions = new question();
$questions->newGame();
?>
