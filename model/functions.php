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
    
    // Create a list of players which played the whole game
    function allPlayers()
    {
        global $newPlayerDAO, $newGameDAO, $newRoundDAO, $newRound1DAO, $newRound2DAO, $newRound3DAO;

        $allPlayers = $newPlayerDAO->getAllPlayers();
        $allPlayers2 = array();

        // check if a player already played a game 
        for ($i=0; $i<count($allPlayers); $i++) // foreach player
        {
            // check if the player played at least one game
            $gamesNb = count($newGameDAO->getAllGamesFromPlayer($allPlayers[$i]["id"]));
            if ($gamesNb != 0)
            {
                // if yes > check how many he played
                for ($j=0; $j<$gamesNb; $j++) // foreach game
                {
                    $gameId = $newGameDAO->getAllGamesFromPlayer($allPlayers[$i]["id"])[$j]["id"];
                    // check if a round exists
                    if (count($newRoundDAO->selectRound($gameId)) != 0)
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
                                    if (!in_array($allPlayers[$i], $allPlayers2))
                                    {
                                        array_push($allPlayers2, $allPlayers[$i]);
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $newGameDAO->deleteGame($gameId);
                    }
                }
            }
            
        }
        return $allPlayers2;
    }

    // Return a game from a player with the max total points and min total time
    function getThePlayerBestGame($playerId)
    {
        global $newGameDAO, $newPlayerDAO;
        // store all the games of the player
        $allGames = $newGameDAO->getAllGamesFromPlayer($playerId);
        // store all the total points of the player
        $allTotalPoints = array();
        for ($i=0; $i<count($allGames); $i++)
        {
            $totalPoints = getTotalPointsFromGame($allGames[$i]["id"]);
            array_push($allTotalPoints, $totalPoints);
        }
        // store all the total time of the player
        $allTotalTimes = array();
        for ($i=0; $i<count($allGames); $i++)
        {
            $totalTimes = getTotalTimesFromGame($allGames[$i]["id"]);
            array_push($allTotalTimes, $totalTimes);
        }
        // store all the scores
        $playerGames = array();
        for ($i=0; $i<count($allGames); $i++)
        {
            array_push($playerGames, array($newPlayerDAO->selectPlayer2($playerId)[0], $allTotalPoints[$i], $allTotalTimes[$i]));
        }

        sortTwoDimensionalArray($playerGames);

        return $playerGames;
    }

    // sorts a multidimensional array (points DESC & times ASC)
    function sortTwoDimensionalArray(&$array) {
        $firstColumn = array_column($array, 0);
        $secondColumn = array_column($array, 1);
        $thirdColumn = array_column($array, 2);
        array_multisort($firstColumn, $secondColumn, SORT_DESC, $thirdColumn, SORT_ASC, $array);
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
        return ($round2WordsNb + $round3RightAnswers + (15 - $round1Tries));
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
        $maxArr = array();
        if (count($arr) < 2) {
            array_push($maxArr, 0);
            return $maxArr;
        }
        else
        {
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
    }

    // Returns an array with the index of the min number (if there are severals)
    function getMinNumber($arr) {
        $minArr = array();
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

?>