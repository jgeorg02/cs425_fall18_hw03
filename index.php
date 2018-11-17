<?php
session_start();
include 'top.html';
include 'question.php';
?>

<script>
    document.getElementById('home_page').classList.add('active');
</script>

<br/>
<br/>
<form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="center container text-center">

        <?php

        $questions = new question();

        if ($_SESSION['game'] != "true")
            $_SESSION['page'] = "start";
        else $_SESSION['page'] = "game";

        if ($_SESSION['page'] == "start") {
            echo '<h3>WELCOME</h3><br/><input id="button" name="button" type="submit" value="START">';
            echo '</div></form><br/><br/>';
            $_SESSION['game'] = "true";
            $_SESSION['page'] = "game";
            $_SESSION['questions'] = 0;
            $_SESSION['level'] = 1;
            $_SESSION['answer'] = "f";
            $_SESSION['points'] = 0;
            $_SESSION['chosen_easy_questions'] = array();
            $_SESSION['chosen_medium_questions'] = array();
            $_SESSION['chosen_hard_questions'] = array();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if ($_POST['button'] == 'END GAME') {
                $_SESSION['game'] = "false";
                session_unset();
                $page = $_SERVER['PHP_SELF'];
                echo '<h3>ENDED GAME</h3> <br/> <h5>Please wait..</h5></div></form><br/><br/>';
                echo '<meta http-equiv="Refresh" content="0;' . $page . '">';
            } else if (($_POST['button'] == 'NEXT') || ($_POST['button'] == 'FINISH') || ($_POST['button'] == 'START')) {

                if ($_POST['button'] != 'START') {

                    $questions->setRightChoice($_SESSION['answer']);
                    $msg = $questions->setAnswer($_POST["ans"]);
                    $_SESSION['points'] = $questions->getTotalPoints();
                    $_SESSION['level'] = $questions->getLevel();
                    echo '<h3> ' . $msg . ' lala ' . $_SESSION['answer'] . ' </h3><p>' . $_SESSION['level'] . ' points: ' . $_SESSION['points'] . ' ' . $_SESSION['chosen_easy_questions'] . length . '</p>';
                }
                $questions->setChosenQuestions($_SESSION['chosen_easy_questions'], $_SESSION['chosen_medium_questions'], $_SESSION['chosen_hard_questions']);
                $questions->setLevelPoints($_SESSION['level'], $_SESSION['points']);
                $chosenquestion = $questions->fetchQuestions();

                $_SESSION['answer'] = $questions->getRightChoice();
                echo '<p>' . $_SESSION['answer'] . '</p>';


                if ($_SESSION['level'] == 0)
                    array_push($_SESSION['chosen_easy_questions'], $chosenquestion);
                else if ($_SESSION['level'] == 1)
                    array_push($_SESSION['chosen_medium_questions'], $chosenquestion);
                else array_push($_SESSION['chosen_hard_questions'], $chosenquestion);
                loadpage();

            } else {
                echo '</div></form><br/><br/>';
            }


        }

        function loadpage()
        {

            $_SESSION['questions']++;
            if ($GLOBALS['questions'] != null)
                if ($_SESSION['questions'] < 5) {

                    echo '<h3>' . $GLOBALS['questions']->getQuestion() . '</h3><p>' . $_SESSION['level'] . ' points: ' . $_SESSION['points'] . '</p>';
                    echo '<label><input type="radio" name="ans" value="f"/><span>' . $GLOBALS['questions']->getChoice1() . '</span></label><br/>';
                    echo '<label><input id="ch1" type="radio" name="ans" value="s"/><span>' . $GLOBALS['questions']->getChoice2() . '</span></label><br/>';
                    echo '<label><input id="ch1" type="radio" name="ans" value="t"/><span>' . $GLOBALS['questions']->getChoice3() . '</span></label><br/>';
                    echo '<input id="button" name="button" type="submit" value="END GAME">';

                    if ($_SESSION['questions'] == 4) echo '<input id="button" name="button" type="submit" value="FINISH">';
                    else echo '<input id="button" name="button" type="submit" value="NEXT">';
                } else {
                    echo '<h3>Your score is: ' . $GLOBALS['questions']->getTotalPoints() . 'Wanna save your score?</h3>';
                    // here should be the implementation of adding the score and nickname
                    session_unset();
                }

            echo '</div></form><br/><br/>';

        }

        ?>

        <!-- Back to top button -->
        <a class="my-btn" href="index.php">Top</a>
        <!-- /Back to top button -->

        <?php
        include 'bottom.html';
        ?>
