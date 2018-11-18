<?php
include 'top.html';
session_start();
session_unset();
?>

<!-- Active the right tab on the navigation bar -->
<script>
    document.getElementById('help_page').classList.add('active');
    document.getElementById('help_page_mob').classList.add('active');
</script>
<!-- /Active the right tab on the navigation bar -->

<div class="padding-top-bottom">
    <div class="container">
        <table>
            <tr>
                <h3>INSTRUCTIONS:</h3>
            </tr>
            <tr>
                <h5>To play the game:</h5>
                <ul>
                    <li>1) Go to the home page</li>
                    <li>2) Press the start button</li>
                    <li>3) Choose the right answer and press 'next' or 'finish'</li>
                </ul>
            </tr>
            <tr><h5>At the end of the game:</h5>
                <p>You will be able to view your performance of the game and your final
                    score. Also you will be able to save your score by giving a nickname.</p></tr>
            <tr><h5>To view the scores:</h5>
                <p>Go to the menu and press 'Scores'.</p></tr>
        </table>
    </div>
</div>

<!-- Back to top button -->
<a class="my-btn" href="help.php">Top</a>
<!-- /Back to top button -->

<?php
include 'bottom.html';
?>
