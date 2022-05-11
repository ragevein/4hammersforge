<audio id="a" src=""></audio>
    <div class="container">
        <div class="card">
            <svg id="Layer_12" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 83 92"><defs></defs><path d="M53.5,2s0,4-6,9V30h-12V13s-9-3-9-13C21,19.5,0,31.5,0,31.5s7,1,7,15c14-16,19-4,19-4S29.5,48,20.5,63a19.06,19.06,0,0,1,15,7l0-29.26h12V67c8-9,15-8,15-8s0,2.11-3-7.44-2.5-15.06,0-17.19,8.46-3.87,12,4.13c0,0,5.46-8,3.46-12S58.5,26,58.5,26a16.19,16.19,0,0,1,1-14C74,9.5,76,18.5,76,18.5s2-13,7-15C83,3.5,59.5,6,53.5,2Zm-25,26c-4-2-11,0-11,0a43.27,43.27,0,0,0,10-12A27.86,27.86,0,0,1,28.5,28Z"/><path class="cls-1" d="M13.5,75a36,36,0,0,1,24,17s-1-11,0-16c-5-13-19-12-19-12Z"/><path class="cls-1" d="M75.5,69.42S55,73.58,46,88.58c0,0,1-11,0-16,5-13,19.52-13.16,19.52-13.16Z"/></svg>
            <div class="content">Treasure Chest ver 1.0<br>Hit the spacebar to stop the cart to catch the gold.</div>
            <div class="game" id="game">
                <div id="coin"></div>
                <div id="cart"></div>
            </div>
            <h2><div class="missed" id="missed">Missed 0</div></h2>
            <h2><div class="gold" id="gold">Gold 0</div></h2>
            <button class="play" id="play">Start</button>
            <button class="stop" id="stop">Stop</button>
            <div id="ctop">var coin top </div>
            <div id="cleft">var coin left </div>
            <div id="cartleft">var cart left </div>
            <div id="scores"><button id="High-Score">Upload Score</button></div>
           
        </div>
        <div class="card-2">
            <h3>Top Scores</h3>Zero Misses
            <?php 
                $query = "SELECT * FROM game_leader WHERE g_loss = 0 ORDER BY g_score DESC LIMIT 3";
                $tScores = mysqli_query($link, $query);
                $records = mysqli_num_rows($tScores);   
                echo '<table width="100%">';
                for ($i = 0; $i < $records; $i++){
                    $row = mysqli_fetch_array($tScores);
                    echo '<tr><td width="100%" align="center" colspan="2">'.$row['g_initials'].'</td></tr>';
                    echo '<tr><td width="50%" align="center">'.$row['g_score'].'</td><td width="50%" align="center">'.$row['g_loss'].'</td></tr>';
                    echo '<tr><td width="50%" align="center">GOLD</td><td width="50%" align="center">MISSED</td></tr>';
                }
                echo '</table>';
            ?>
             <h3>Top Scores</h3>Highest
            <?php 
                $query = "SELECT * FROM game_leader WHERE g_loss != 0 ORDER BY g_score DESC LIMIT 3";
                $tScores = mysqli_query($link, $query);
                $records = mysqli_num_rows($tScores);   
                echo '<table width="100%">';
                for ($i = 0; $i < $records; $i++){
                    $row = mysqli_fetch_array($tScores);
                    echo '<tr><td width="100%" align="center" colspan="2">'.$row['g_initials'].'</td></tr>';
                    echo '<tr><td width="50%" align="center">'.$row['g_score'].'</td><td width="50%" align="center">'.$row['g_loss'].'</td></tr>';
                    echo '<tr><td width="50%" align="center">GOLD</td><td width="50%" align="center">MISSED</td></tr>';
                }
                echo '</table>';
            ?>
        </div>
    </div>
    <dialog id="modal">
        <div class="upload_form">
            <form method="post" action="process.php" name="awesome">
                    <input type="hidden" name="action" value="leaderboard">
                    <input type="hidden" name="game" value="1">
                    <input type="hidden" name="gold" id="g-score" value="">
                    <input type="hidden" name="missed" id="m-score" value="">
                    <?php
                    if (isset($_SESSION['u_id'])){
                        echo 'Nice Score Enter your initials for the leader board.<br><br>';
                        echo '<input type="hidden" name="user" value="'.$_SESSION['u_id'].'">';
                    }
                    else {
                        echo 'Hello guest, enter your initials to show your score on the leader board.<br><br>';
                    }
        echo '<div id="initial">';
                    echo '&nbsp;<input type="text" name="one" size="1" maxlength="1""> <input type="text" name="two" size="1" maxlength="1"> <input type="text" name="three" size="1" maxlength="1"><br><br>';
                    ?>

                <input type="submit" class="slider" value=" UPLOAD ">
            </form><button id="Cancel"> CANCEL </cancel>
        </div></div>
    </dialog>
    <script src="tchest.js"></script>