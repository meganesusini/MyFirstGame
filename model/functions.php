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

    $players = allPlayers();

    // FUNCTIONS //

    //test
    function displaysplayers()
    {
        global $newPlayerDAO;
        $players = $newPlayerDAO->getAllPlayers();
        for ($i=0; $i<count($players); $i++)
        {
            echo $players[$i]["pseudo"] . "<br>";
        }
    }
    
    // Create a list of players which played the whole game
    function allPlayers()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;

        $allPlayers = $newPlayerDAO->getAllPlayers(); 
        $allPlayers2 = [];

        for ($i=0; $i<count($allPlayers); $i++)
        {
            $gameId = $newGameDAO->selectGame($allPlayers[$i]["id"])[0]["MAX(id)"];
            // check if a round exists
            if (count($newRoundDAO->selectRound($gameId)) == 0)
            {
                // if not > delete game
                $newGameDAO->deleteGame($gameId);
            }
            else 
            {
                $roundId = $newRoundDAO->selectRound($gameId)[0]["id"];
                // check if a round1 exists
                if (count($newRound1DAO->selectRound1($roundId)) == 0)
                {
                    // if not > delete round > game
                    $newRoundDAO->deleteRound($roundId);
                    $newGameDAO->deleteGame($gameId);
                }
                else
                {
                    // check if a round2 exists
                    if (count($newRound2DAO->selectRound2($roundId)) == 0)
                    {
                        // if not > delete round1 > round > game
                        $newRound1DAO->deleteRound1($roundId);
                        $newRoundDAO->deleteRound($roundId);
                        $newGameDAO->deleteGame($gameId);
                    }
                    else
                    {
                        // check if a round3 exists
                        if (count($newRound3DAO->selectRound3($roundId)) == 0)
                        {
                            // if not > delete round2 > round1 > round > game
                            $newRound2DAO->deleteRound2($roundId);
                            $newRound1DAO->deleteRound1($roundId);
                            $newRoundDAO->deleteRound($roundId);
                            $newGameDAO->deleteGame($gameId);
                        }
                        else
                        {
                            array_push($allPlayers2, $allPlayers[$i]);
                        }
                    }
                }
            }
        }
        return $allPlayers2;
    }

    // Return the max total points and time of a player
    function getThePlayerBestGame($playerId)
    {
        global $newGameDAO;
        // store all the games of the player
        $allGames = $newGameDAO->getAllGamesFromPlayer($playerId);
        // store all the total points of the player
        $allTotalPoints = [];
        for ($i=0; $i<count($allGames); $i++)
        {
            $totalPoints = getTotalPointsFromGame($allGames[$i]["id"]);
            array_push($allTotalPoints, $totalPoints);
        }
        // store all the total time of the player
        $allTotalTimes = [];
        for ($i=0; $i<count($allGames); $i++)
        {
            $totalTimes = getTotalTimesFromGame($allGames[$i]["id"]);
            array_push($allTotalTimes, $totalTimes);
        }
        // store all the index of the max total points in an array
        $maxTotalPointsIndex = getMaxNumber($allTotalPoints);
        // if count(array) == 1 -> $theBestPlayerGame = a game
        if (count($maxTotalPointsIndex) == 1)
        {
            $theBestPlayerGame = $newGameDAO->selectGame2($allGames[$maxTotalPointsIndex[0]]["id"])[0];
        }
        else
        {
            // else -> store all the total times with the same index of the max total points
            $allTotalTimes2 = [];
            for ($i=0; $i<count($maxTotalPointsIndex); $i++)
            {
                $totalTimes = getTotalTimesFromGame($allGames[$maxTotalPointsIndex[$i]]["id"]);
                array_push($allTotalTimes2, $totalTimes);
            }
            $minTotalTimesIndex = getMinNumber($allTotalTimes2)[0];
            $theBestPlayerGame = $newGameDAO->selectGame2($allGames[$minTotalTimesIndex]["id"])[0];
        }
        return $theBestPlayerGame;
    }

    // Returns the total points from a game
    function getTotalPointsFromGame($gameId)
    {
        global $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;
        $roundId = $newRoundDAO->selectRound($gameId)[0]["id"]; 
        $round1Tries = $newRound1DAO->selectRound1($roundId)[0]["triesNb"]; // /15
        $round2WordsNb = $newRound2DAO->selectRound2($roundId)[0]["wordsNb"]; // /14
        $round3RightAnswers = $newRound3DAO->selectRound3($roundId)[0]["rightAnswersNb"]; // /3
        if ($round1Tries > 15)
        {
            $round1Tries = 15;
        }
        return $round2WordsNb + $round3RightAnswers + (15 - $round1Tries);
    }

    // Returns the total times from a game
    function getTotalTimesFromGame($gameId)
    {
        global $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;
        $roundId = $newRoundDAO->selectRound($gameId)[0]["id"]; 
        $round1Time = $newRound1DAO->selectRound1($roundId)[0]["timeSpent"];
        $round2Time = $newRound2DAO->selectRound2($roundId)[0]["timeSpent"];
        $round3Time = $newRound3DAO->selectRound3($roundId)[0]["timeSpent"];
        return $round1Time + $round2Time + $round3Time;
    }

    // Returns an array with the index of the max number (if there are severals)
    function getMaxNumber($arr) {
        $maxArr = [];
        $max = $arr[0];
        for ($i = 1; $i < count($arr); $i++) {
          if ($arr[$i] > $max) {
            $max = $arr[$i];
          }
        }
        for ($i = 0; $i < count($arr); $i++) {
          if ($arr[$i] == $max) {
            array_push($maxArr, $i);
          }
        }
        return $maxArr;
    }

    // Returns an array with the index of the min number (if there are severals)
    function getMinNumber($arr) {
        $minArr = [];
        $min = $arr[0];
        for ($i = 1; $i < count($arr); $i++) {
          if ($arr[$i] < $min) {
            $min = $arr[$i];
          }
        }
        for ($i = 0; $i < count($arr); $i++) {
          if ($arr[$i] == $min) {
            array_push($minArr, $i);
          }
        }
        return $minArr;
    }

    // Return the total time of a player
    // function totalTime($playerId)
    // {
    //     global $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO, $players;
    //     $gameId = $newGameDAO->selectGame($playerId)[0]["MAX(id)"];
    //     $roundId = $newRoundDAO->selectRound($gameId)[0]["id"];
    //     $round1Time = $newRound1DAO->selectRound1($roundId)[0]["timeSpent"];
    //     $round2Time = $newRound2DAO->selectRound2($roundId)[0]["timeSpent"];
    //     $round3Time = $newRound3DAO->selectRound3($roundId)[0]["timeSpent"];
    //     $totalTime = $round1Time + $round2Time + $round3Time;
    // }
    // ALL THE TABLES //
    // the best players of the game
    function displayBestPlayers()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO, $players;

        // get the players
        // $players = $newPlayerDAO->getAllPlayers(); 
        // $players = allPlayers();

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
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO, $players;

        // get the players
        // $players = $newPlayerDAO->getAllPlayers(); 

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
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO, $players;

        // get the players
        // $players = $newPlayerDAO->getAllPlayers(); 

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

        // get the players
        // $players = $newPlayerDAO->getAllPlayers(); 

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

        // get the players
        // $players = $newPlayerDAO->getAllPlayers(); 

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