<?php
include 'top.html';
include 'players.php';
session_start();
session_unset();
?>

    <!-- Active the right tab on the navigation bar -->
    <script>
        document.getElementById('scores_page').classList.add('active');
        document.getElementById('scores_page_mob').classList.add('active');
    </script>
    <!-- /Active the right tab on the navigation bar -->

    <div class="padding-top-bottom">
        <div class="container text-center">
            <h3>Scores: </h3>
            <div class="container">

                <?php
                $players = players::fetchPlayers();

                $players_array = explode(PHP_EOL, $players);
                echo '<table style="text-align:center;"><tbody>';
                foreach ($players_array as $item)
		    if ($item != "")
                        echo '<tr><td><li style="list-style-type:square">' . $item . '</li></td></tr>';

                echo '</tbody></table>';
                ?>
            </div>
        </div>
    </div>
    <!-- Back to top button -->
    <a class="my-btn" href="scores.php">Top</a>
    <!-- /Back to top button -->

<?php
include 'bottom.html';
?>
