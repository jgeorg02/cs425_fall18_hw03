<?php
session_start();
if (!isset($_SESSION['game']))
    $_SESSION['game'] = "false";
if (!isset($_SESSION['page']))
    $_SESSION['page'] = "start";
if (!isset($_SESSION['questions']))
    $_SESSION['questions'] = 0;
if (!isset($_SESSION['level']))
    $_SESSION['level'] = 1;
if (!isset($_SESSION['points']))
    $_SESSION['points'] = 0;
if (!isset($_SESSION['chosen_easy_questions']))
    $_SESSION['chosen_easy_questions'] = array();
if (!isset($_SESSION['chosen_medium_questions']))
    $_SESSION['chosen_medium_questions'] = array();
if (!isset($_SESSION['chosen_hard_questions']))
    $_SESSION['chosen_hard_questions'] = array();
if (!isset($_SESSION['performance']))
    $_SESSION['performance'] = array();

include 'top.html';
include 'question.php';
include 'players.php';
?>

    <!-- Active the right tab on the navigation bar -->
    <script>
        document.getElementById('home_page').classList.add('active');
        document.getElementById('home_page_mob').classList.add('active');
    </script>
    <!-- /Active the right tab on the navigation bar -->

    <!-- The beggining of the form -->
    <br/>
    <br/>
    <div class="padding-top-bottom">
        <div class="container">
            <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="center container text-center">

                    <?php

                    // object the fetches questions from the xml
                    $questions = new question();
                    // total number of questions that the game will contain
                    $num_questions = 5;

                    // checks if the game has started or not
                    if ($_SESSION['game'] != "true")
                        $_SESSION['page'] = "start";

                    else $_SESSION['page'] = "game";

                    // checks if the player is playing or just entered the page
                    if ($_SESSION['page'] == "start") {
                        echo '<h3>WELCOME</h3><br/><input id="button" name="button" type="submit" value="START">';
                        echo '</div></form></div></div><br/><br/>';
                        $_SESSION['game'] = "true";
                        $_SESSION['page'] = "game";
                    }

                    // handles post request
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        // if the player ends the game or didn't choose to save his/her nickname, it unsets the session and reloads the page so the welcome page will be shown.
                        if (($_POST['button'] == 'END GAME') || ($_POST['button'] == 'CANCEL')) {

                            session_unset();
                            $page = $_SERVER['PHP_SELF'];
                            if ($_POST['button'] == 'END GAME')
                                echo '<h3>ENDED GAME</h3> <br/>';
                            echo '<h5>Please wait..</h5></div></form></div></div><br/><br/>';
                            echo '<meta http-equiv="Refresh" content="0;' . $page . '">';

                        } else if (($_POST['button'] == 'NEXT') || ($_POST['button'] == 'FINISH') || ($_POST['button'] == 'START')) {

                            // checks the answer that the user gave and calculates the level and the points
                            if ($_POST['button'] != 'START') {

                                $msg = "<h5>Question: " . ($_SESSION['questions']) . "<br />Level: " . $_SESSION['level'] . "<br />Points: " . $_POST["points"];

                                if ($_POST["right_answer"] != $_POST["ans"]) {
                                    if (($_SESSION['level'] == 1) || ($_SESSION['level'] == 2)) $_SESSION['level']--;
                                    $msg .= '<br />Answer: Wrong</h5><br /><br />';
                                } else {
                                    if (($_SESSION['level'] == 0) || ($_SESSION['level'] == 1)) $_SESSION['level']++;
                                    $_SESSION['points'] += $_POST["points"];
                                    $msg .= '<br />Answer: Correct</h5><br /><br />';
                                }

                                array_push($_SESSION['performance'], $msg);
                            }

                            // fetches the new question
                            if ($_POST['button'] != 'FINISH') {

                                $questions->setChosenQuestions($_SESSION['chosen_easy_questions'], $_SESSION['chosen_medium_questions'], $_SESSION['chosen_hard_questions']);
                                $questions->setLevel($_SESSION['level']);
                                $random = $questions->fetchQuestions();

                                switch ($_SESSION['level']) {
                                    case 0:
                                        array_push($_SESSION['chosen_easy_questions'], $random);
                                        break;
                                    case 1:
                                        array_push($_SESSION['chosen_medium_questions'], $random);
                                        break;
                                    case 2:
                                        array_push($_SESSION['chosen_hard_questions'], $random);
                                        break;
                                }

                            }

                            loadpage();

                        } else if ($_POST['button'] == 'SAVE') {

                            $success = players::savePlayer($_POST['nickname'], $_SESSION['points']);

                            session_unset();
                            $page = $_SERVER['PHP_SELF'];

                            if ($success === true)
                                echo '<h5>Your score is saved successfully!</h5>';
                            else echo '<h5>Your score is not saved!</h5>';
                            echo '</div></form></div></div><br/><br/>';

                            echo '<meta http-equiv="Refresh" content="0;' . $page . '">';

                        } else {
                            echo '</div></form></div></div><br/><br/>';
                        }


                    }

                    /**
                     * This function loads the page that will contain the question, the choices and the buttons to end the game, and to continue or finish it.  If the question has finished
                     * it loads the points and it gives the opportunity for the user to save his score by giving a nickname.
                     */
                    function loadpage()
                    {

                        $_SESSION['questions']++; // increases questions
                        if ($GLOBALS['questions'] != null)

                            // loads the questions and choices form
                            if ($_SESSION['questions'] < $GLOBALS['num_questions'] + 1) {

                                echo '<h3>' . $GLOBALS['questions']->getQuestion() . '</h3>';
                                echo '<label><input type="radio" name="ans" value="f"/><span>' . $GLOBALS['questions']->getChoice1() . '</span></label><br/>';
                                echo '<label><input type="radio" name="ans" value="s"/><span>' . $GLOBALS['questions']->getChoice2() . '</span></label><br/>';
                                echo '<label><input type="radio" name="ans" value="t"/><span>' . $GLOBALS['questions']->getChoice3() . '</span></label><br/>';
                                echo '<input type="hidden" name="right_answer" value="' . $GLOBALS["questions"]->getRightChoice() . '"/>';
                                echo '<input type="hidden" name="points" value="' . $GLOBALS["questions"]->getQPoints() . '"/>';
                                echo '<input id="button" name="button" type="submit" value="END GAME">';

                                // checks if it's the last question
                                if ($_SESSION['questions'] == $GLOBALS['num_questions']) echo '<input id="button" name="button" type="submit" value="FINISH">';
                                else echo '<input id="button" name="button" type="submit" value="NEXT">';
                                echo '<p>Question: ' . $_SESSION['questions'] . ' of ' . $GLOBALS['num_questions'] . '</p>';
                            } else {
                                echo '<h3>Your performance:</h3>';
                                foreach ($_SESSION['performance'] as $item)
                                    echo $item;
                                echo '<h3>Your score is: ' . $_SESSION['points'] . '<br /> Want to save your score?</h3>';
                                echo '<label><h5>Nickname</h5></label><input type="text" name="nickname" placeholder="John Smith">';
                                echo '<input id="button" name="button" type="submit" value="CANCEL">';
                                echo '<input id="button" name="button" type="submit" value="SAVE">';
                            }

                        echo '</div></form></div></div><br/><br/>';

                    }

                    ?>

                    <!-- Back to top button -->
                    <a class="my-btn" href="index.php">Top</a>
                    <!-- /Back to top button -->

<?php
include 'bottom.html';
?>