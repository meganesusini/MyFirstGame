<?php
    require("functions.php");

    // ALL THE TABLES //
    // the best players of the game
    function displayBestPlayers()
    {
        global $players;

        $bestPlayers_players = array();
        $bestPlayers_points = array();
        $bestPlayers_times = array();
        for ($i=0; $i<count($players); $i++)
        {
            array_push($bestPlayers_players, getThePlayerBestGame($players[$i]["id"])[0][0]);
            array_push($bestPlayers_points, getThePlayerBestGame($players[$i]["id"])[0][1]);
            array_push($bestPlayers_times, getThePlayerBestGame($players[$i]["id"])[0][2]);
        }
    
        // displays the ranking
        $tableHtml = "<table class='bestPlayersRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TOTAL TIME", "TOTAL POINTS /32"];

        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($players); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $bestPlayers_players[$i]["pseudo"] . "</td>"; // user name
            $tableHtml .= "<td>" . strval($bestPlayers_times[$i]) . " seconds</td>"; // total time
            $tableHtml .= "<td>" . strval($bestPlayers_points[$i]) . " points</td></tr>"; // total points
        }

        $tableHtml .= "</tbody></table>";

        echo $tableHtml;

    }


    // ROUND1
    function displayRound1Rank()
    {
        // store the ranking
        $rankingRound1 = $newRound1DAO->rankingRound1();
        $newRankingR1 = array();
        // first : check the doubles
        if (count($rankingRound1) > 1)
        {
            $pseudosArray = array(); // array of doubles
            for ($i=0; $i<count($rankingRound1); $i++)
            {
                // if not doubles
                if (!(in_array($rankingRound1[$i]["pseudo"], $pseudosArray)))
                {
                    array_push($pseudosArray, $rankingRound1[$i]["pseudo"]);
                    array_push($newRankingR1, array($rankingRound1[$i]["pseudo"], $rankingRound1[$i]["triesNb"], $rankingRound1[$i]["timeSpent"]));
                }
            }
        }

        // displays the ranking
        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "TRIES"];

        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($newRankingR1); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $newRankingR1[$i][0] . "</td>"; // user name
            $tableHtml .= "<td>" . strval($newRankingR1[$i][2]) . " seconds</td>"; // round1 time
            $tableHtml .= "<td>" . strval($newRankingR1[$i][1]) . " tries</td></tr>"; // round1 tries
        }

        $tableHtml .= "</tbody></table>";

        echo $tableHtml;

    }


    // ROUND2
    function displayRound2Rank()
    {      
        // store the ranking
        $rankingRound2 = $newRound2DAO->rankingRound2();
        $newRankingR2 = array();
        // first : check the doubles
        if (count($rankingRound2) > 1)
        {
            $pseudosArray = array(); // array of doubles
            for ($i=0; $i<count($rankingRound2); $i++)
            {
                // if not doubles
                if (!(in_array($rankingRound2[$i]["pseudo"], $pseudosArray)))
                {
                    array_push($pseudosArray, $rankingRound2[$i]["pseudo"]);
                    array_push($newRankingR2, array($rankingRound2[$i]["pseudo"], $rankingRound2[$i]["wordsNb"], $rankingRound2[$i]["timeSpent"]));
                }
            }
        }

        // displays the ranking
        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "WORDS FOUND /14"];

        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($newRankingR2); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $newRankingR2[$i][0] . "</td>"; // user name
            $tableHtml .= "<td>" . strval($newRankingR2[$i][2]) . " seconds</td>"; // round2 time
            $tableHtml .= "<td>" . strval($newRankingR2[$i][1]) . " word(s) found</td></tr>"; // round2 words found
        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    }


    // ROUND3
    function displayRound3Rank()
    {
        // store the ranking
        $rankingRound3 = $newRound3DAO->rankingRound3();
        $newRankingR3 = array();
        // first : check the doubles
        if (count($rankingRound3) > 1)
        {
            $pseudosArray = array(); // array of doubles
            for ($i=0; $i<count($rankingRound3); $i++)
            {
                // if not doubles
                if (!(in_array($rankingRound3[$i]["pseudo"], $pseudosArray)))
                {
                    array_push($pseudosArray, $rankingRound3[$i]["pseudo"]);
                    array_push($newRankingR3, array($rankingRound3[$i]["pseudo"], $rankingRound3[$i]["rightAnswersNb"], $rankingRound3[$i]["timeSpent"]));
                }
            }
        }

        // displays the ranking
        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "RIGHT ANSWERS /3"];

        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";
        for ($i = 0; $i < count($newRankingR3); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $newRankingR3[$i][0] . "</td>"; // user name
            $tableHtml .= "<td>" . strval($newRankingR3[$i][2]) . " seconds</td>"; // round3 time
            $tableHtml .= "<td>" . strval($newRankingR3[$i][1]) . " right answer(s)</td></tr>"; // round3 right answers
        }

        $tableHtml .= "</tbody></table>";
        
        echo $tableHtml;

    }

?>