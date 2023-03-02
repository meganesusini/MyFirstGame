<?php
    require("../model/BdPdoConnection.php");
    require("../model/PlayerDAO.php");
    require("../model/GameDAO.php");
    require("../model/RoundDAO.php");
    require("../model/Round1DAO.php");
    require("../model/Round2DAO.php");
    require("../model/Round3DAO.php");      

    $newPlayerDAO = new PlayerDAO(BdPdoConnection::getConnection());
    $newGameDAO = new GameDAO(BdPdoConnection::getConnection());
    $newRoundDAO = new RoundDAO(BdPdoConnection::getConnection());
    $newRound1DAO = new Round1DAO(BdPdoConnection::getConnection());
    $newRound2DAO = new Round2DAO(BdPdoConnection::getConnection());
    $newRound3DAO = new Round3DAO(BdPdoConnection::getConnection());

    // FUNCTIONS //

    // the best players of the game
    function displayBestPlayers()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;

        // get the players
        $players = $newPlayerDAO->getAllPlayers(); 

        $tableHtml = "<table class='bestPlayersRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TOTAL TIME", "TOTAL POINTS /32"];

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

            $tableHtml .= "<td>" . strval($totalPoints) . " points</td></tr>";
        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    }

    // round1 ranking
    function displayRound1Rank()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;

        // get the players
        $players = $newPlayerDAO->getAllPlayers(); 

        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "TRIES"];

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
            $round1Time = $newRound1DAO->selectRound1($roundId)[0]["timeSpent"];
            $tableHtml .= "<td>" . strval($round1Time) . " seconds</td>"; // round1 time
            $round1Tries = $newRound1DAO->selectRound1($roundId)[0]["triesNb"]; // /15
            $tableHtml .= "<td>" . strval($round1Tries) . " tries</td></tr>"; // round1 tries
        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    }

    // round2 ranking
    function displayRound2Rank()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;

        // get the players
        $players = $newPlayerDAO->getAllPlayers(); 

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
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;

        // get the players
        $players = $newPlayerDAO->getAllPlayers(); 

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
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;

        // get the players
        $players = $newPlayerDAO->getAllPlayers(); 

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