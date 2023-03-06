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
    
        $tableHtml = "<table class='bestPlayersRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TOTAL TIME", "TOTAL POINTS /32"];

        // add the headers
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

    // round1 ranking
    function displayRound1Rank()
    {
        global $newRound1DAO;

        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "TRIES"];

        // add the headers
        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        // store the ranking
        $rankingRound1 = $newRound1DAO->rankingRound1();
        $newRankingR1 = array();
        // first : check the doubles
        if (count($rankingRound1) > 1)
        {
            $pseudosArray = array();
            for ($i=0; $i<count($rankingRound1); $i++)
            {
                if (in_array($rankingRound1[$i]["pseudo"], $pseudosArray))
                {
                    array_splice($rankingRound1, $i, 1);
                }
                else
                {
                    array_push($pseudosArray, $rankingRound1[$i]["pseudo"]);
                }
            }
        }


        for ($i=0; $i<count($rankingRound1); $i++)
        {
            if (!in_array($rankingRound1[$i]["pseudo"], $newRankingR1))
            {
                array_push($newRankingR1, array($rankingRound1[$i]["pseudo"], $rankingRound1[$i]["triesNb"], $rankingRound1[$i]["timeSpent"]));
            }
        }

        for ($i = 0; $i < count($newRankingR1); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $newRankingR1[$i][0] . "</td>"; // user name
            $tableHtml .= "<td>" . strval($newRankingR1[$i][2]) . " seconds</td>"; // round1 time
            $tableHtml .= "<td>" . strval($newRankingR1[$i][1]) . " tries</td></tr>"; // round1 tries
        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    }

    // round2 ranking
    function displayRound2Rank()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO, $players;


        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "WORDS FOUND /14"];

        // add the headers
        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($players); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $players[$i]["pseudo"] . "</td>"; // user name
            $gameId = $newGameDAO->selectGame($players[$i]["id"])[0]["MAX(id)"];
            $roundId = $newRoundDAO->selectRound($gameId)[0]["id"];
            $round2Time = $newRound2DAO->selectRound2($roundId)[0]["timeSpent"];
            $tableHtml .= "<td>" . strval($round2Time) . " seconds</td>"; // round2 time
            $round2WordsNb = $newRound2DAO->selectRound2($roundId)[0]["wordsNb"]; // /14
            $tableHtml .= "<td>" . strval($round2WordsNb) . " word(s) found</td></tr>"; // round2 words found
        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    }

    // round3 ranking
    function displayRound3Rank()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO, $players;
 

        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "RIGHT ANSWERS /3"];

        // add the headers
        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($players); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $players[$i]["pseudo"] . "</td>"; // user name
            $gameId = $newGameDAO->selectGame($players[$i]["id"])[0]["MAX(id)"];
            $roundId = $newRoundDAO->selectRound($gameId)[0]["id"];
            $round3Time = $newRound3DAO->selectRound3($roundId)[0]["timeSpent"];
            $tableHtml .= "<td>" . strval($round3Time) . " seconds</td>"; // round3 time
            $round3RightAnswers = $newRound3DAO->selectRound3($roundId)[0]["rightAnswersNb"]; // /3
            $tableHtml .= "<td>" . strval($round3RightAnswers) . " right answer(s)</td></tr>"; // round3 right answers
        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    }

    // global array
    function displayRankTable()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO, $players;

        $tableHtml = "<table class='rankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TOTAL TIME", "TOTAL POINTS /32", "ROUND1 : TIME", "ROUND1 : TRIES", "ROUND2 : TIME", "ROUND2 : WORDS FOUND /14", "ROUND3 : TIME", "ROUND3 : RIGHT ANSWERS /3"];

        // add the headers
        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($players); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $players[$i]["pseudo"] . "</td>"; // user name
            
            // total time
            $gameId = $newGameDAO->selectGame($players[$i]["id"])[0]["MAX(id)"];
            $roundId = $newRoundDAO->selectRound($gameId)[0]["id"];
            $round1Time = $newRound1DAO->selectRound1($roundId)[0]["timeSpent"];
            $round2Time = $newRound2DAO->selectRound2($roundId)[0]["timeSpent"];
            $round3Time = $newRound3DAO->selectRound3($roundId)[0]["timeSpent"];
            $totalTime = $round1Time + $round2Time + $round3Time;

            $tableHtml .= "<td>" . strval($totalTime) . " seconds</td>";

            // total points
            $round1Tries = $newRound1DAO->selectRound1($roundId)[0]["triesNb"]; // /15
            $round2WordsNb = $newRound2DAO->selectRound2($roundId)[0]["wordsNb"]; // /14
            $round3RightAnswers = $newRound3DAO->selectRound3($roundId)[0]["rightAnswersNb"]; // /3
            if ($round1Tries > 15)
            {
                $round1Tries = 15;
            }
            $totalPoints = $round2WordsNb + $round3RightAnswers + (15 - $round1Tries);

            $tableHtml .= "<td>" . strval($totalPoints) . " points</td>";

            $tableHtml .= "<td>" . strval($round1Time) . " seconds</td>"; // round1 time
            $tableHtml .= "<td>" . strval($round1Tries) . " tries</td>"; // round1 tries
            $tableHtml .= "<td>" . strval($round2Time) . " seconds</td>"; // round2 time
            $tableHtml .= "<td>" . strval($round2WordsNb) . " word(s) found</td>"; // round2 words found
            $tableHtml .= "<td>" . strval($round3Time) . " seconds</td>"; // round3 time
            $tableHtml .= "<td>" . strval($round3RightAnswers) . " right answer(s)</td></tr>"; // round3 right answers

        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    }
?>