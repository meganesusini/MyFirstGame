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
                // if yes > check how many times he played
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

?>