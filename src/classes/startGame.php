<?php
namespace Eric\CodeChallenge;

class StartGame {
    // start the game
    public function start (): void {
        // initialize stores
        $this->initialize();

        // log
        $this->log("BEGIN // Test {$this->sessionUniqueId} // " . date('l j, F Y H:i:s') . "\n");
        $this->log("Dice Sides = [ " . implode(', ', $this->diceSides) . " ]" . "\n");
        $this->log("Range of knights to play = [ " . implode(', ', $this->knightsRange) . " ]" . "\n");
        $this->log("Randomly selected key index from range of knights = {$this->randomKeyIndex}" . "\n");
        $this->log("Autoselected number of knights to play = {$this->knightsNumber}" . "\n");

        // check if just 1 or no knight available / since specification says "any number of knights"
        if ($this->knightsNumber < 1) {
            // message
            $this->result = "No knights available to play!" . "\n";

            // log
            $this->log($this->result);
        }
        else if ($this->knightsNumber == 1) {
            // roll dice
            $this->rollDice();

            // subtract the dice sides rolled from the life points
            $aftermath = $this->knightsAndLifePoints[1] - $this->diceSideRolled;

            // check if remainder is zero or not
            if ($aftermath <= 0) {
                // message
                $this->result = "The single knight" . "\n";
                $this->result .= "Had {$this->knightsAndLifePoints[1]} points before rolling" . "\n";
                $this->result .= "Then had approx. 0 point (actually: $aftermath) after rolling {$this->diceSideRolled} and had to be removed from the playing field" . "\n";
                $this->result .= "No knight was left remaining to be crowned the winner\n";
            } else {
                // message
                $this->result = "The single knight" . "\n";
                $this->result .= "Had {$this->knightsAndLifePoints[1]} points before rolling" . "\n";
                $this->result .= "Then had $aftermath points after rolling {$this->diceSideRolled} and was crowned the winner" . "\n";
            }

            // log
            $this->log($this->result);
        } else {
            // log
            $this->log("All knights and their respective life points starting from 'Knight 1' to 'Knight {$this->knightsNumber}' = " . print_r($this->knightsAndLifePoints, true));
            
            // keep looping if more than one knight is still alive
            while (count($this->knightsAndLifePoints) > 1) {

                // log
                $this->log();
                $this->log("ROUND {$this->roundsCounter}" . "\n");

                // loop through knights and 
                foreach ($this->knightsAndLifePoints as $knightIndex => $lifePoints) {
                    // log
                    $this->log("Knight $knightIndex" . "\n");
                    $this->log("Had $lifePoints points before rolling the dice" . "\n");

                    // roll dice
                    $this->rollDice();

                    // subtract the dice sides rolled from the life points
                    $aftermath = $lifePoints - $this->diceSideRolled;

                    // check if zero or less than zero and remove this knight from field
                    if ($aftermath <= 0) {
                        // log
                        $this->log("Then had approx. 0 point (actually: $aftermath) after rolling {$this->diceSideRolled} and had to be removed from the playing field" . "\n");

                        // get array keys as values of a new numeric array
                        $getArrayOfKeys = array_keys($this->knightsAndLifePoints);
                        
                        // flip newly created numeric array so keys become values and values become keys to get the numeric indices as values
                        $getArrayOfKeysFlipped = array_flip($getArrayOfKeys);
                        
                        // get the newly found index of the current key in loop 
                        $getIndexOfCurrentLoopKey = $getArrayOfKeysFlipped[$knightIndex];
                        
                        // get all knights before this one
                        $knightsBefore = array_slice($this->knightsAndLifePoints, 0, $getIndexOfCurrentLoopKey, true);
                        
                        // get all knights after this one
                        $knightsAfter = array_slice($this->knightsAndLifePoints, ($getIndexOfCurrentLoopKey + 1), (count($this->knightsAndLifePoints) - 1), true);

                        // get the new list of living and playing knights
                        $this->knightsAndLifePoints = array_replace($knightsBefore, $knightsAfter);
                        
                        // log
                        $this->log("All knights remaining and their life points after removing 'Knight $knightIndex' = " . print_r($this->knightsAndLifePoints, true) . "\n");
                    } else {
                        // place the new life points back
                        $this->knightsAndLifePoints[$knightIndex] = $aftermath;

                        // log
                        $this->log("Then had $aftermath points after rolling {$this->diceSideRolled}" . "\n");
                    }

                    // break out of the loop once there's just one knight remaining
                    if(count($this->knightsAndLifePoints) == 1) break 1;
                }

                // increase counter
                $this->roundsCounter++;

            }

            // get last knight
            $this->lastRemainingKnightNumber = implode('', array_keys($this->knightsAndLifePoints));
            $this->lastRemainingKnightPoints = implode('', array_values($this->knightsAndLifePoints));

            // get result statement
            $this->result = "At the end, the winner was 'Knight {$this->winner()}' with {$this->lastPoints()} point(s) remaining" . "\n";

            // log
            $this->log($this->result);
        }

        // log
        $this->log("END // Test {$this->sessionUniqueId} // " . date('l j, F Y H:i:s') . "\n\n");
        $this->log("------------------------------------------------------------------------------------------------------" . "\n\n");
    }
}