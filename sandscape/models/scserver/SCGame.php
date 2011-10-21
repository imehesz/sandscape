<?php


class SCGame
{
   private $all = array();
   private $roots = array();

   /**
    *
    * @var SCPlayerSide 
    */
   private $player1Side;

   /**
    *
    * @var SCPlayerSide 
    */
   private $player2Side;

   /**
    * If a card is not anywhere, is in void
    * @var SCContainer
    */
   private $void;

   /**
    * TODO: document this....
    */
   public function __construct($hasGraveyard, $player1, $player2, $handWidth = 10, $handHeight = 10, $gameWidth = 70, $gameHeight = 30)
   {
      $this->player1Side = new SCPlayerSide($player1, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
      $this->player2Side = new SCPlayerSide($player2, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
      $this->void = new SCContainer($this, false, false);
   }

   public function __wakeup()
   {
      $this->roots = array();
   }

   public function register(SCContainer $c)
   {
      $this->all[$c->getId()] = $c;
   }

   public function unregister(SCContainer $c)
   {
      unset($this->all[$c->getId()]);
   }
   
   public function getRoot(SCContainer $scc)
   {
      if (isset($this->roots[$scc->getId()])) return $this->roots[$scc->getId()];
      return null;
   }

   public function addPlayer1Deck(SCDeck $deck)
   {
      $this->player1Side->addDeck($deck);
   }

   public function addPlayer2Deck(SCDeck $deck)
   {
      $this->player2Side->addDeck($deck);
   }

   /**
    * Returns the current player side
    * 
    * @param  int          $userId     User who originated the reques
    * @return SCPlayerSide 
    */
   public function getPlayerSide($userId)
   {
      $side = ($this->player1Side->getPlayerId() == $userId ? $this->player1Side :
                  ($this->player2Side->getPlayerId() == $userId ? $this->player2Side : null));

      $this->roots[$side->getHand()->getId()] = $side->getHand();
      $this->roots[$side->getPlayableArea()->getId()] = $side->getPlayableArea();
      if ($side->getGraveyard()) $this->roots[$side->getGraveyard()->getId()] = $side->getGraveyard();
      foreach ($side->getDecks() as $deck) $this->roots[$deck->getId()] = $deck;

      return $side;
   }

   /**
    * Returns the opponent side of the game
    * @param  int          $userId     User who originated the reques
    * @return SCPlayerSide
    */
   public function getOpponentSide($userId)
   {
      $side = ($this->player1Side->getPlayerId() == $userId ? $this->player2Side :
                  ($this->player2Side->getPlayerId() == $userId ? $this->player1Side : null));
      
      $this->roots [$side->getPlayableArea()->getId()] = $side->getPlayableArea();

      return $side;
   }

   public function getVoid()
   {
      return $this->void;
   }

   /**
    * Returns all elements positions
    * 
    * I have the feeling that this one will try to bite me in the ass later.... 
    * 
    * @return array
    */
   public function getGameStatus()
   {
      $update = array();
      
      foreach($this->all as $c)
      {
         if ($c->isMovable())
         {
            $root = $c->getRoot();
         
            $update [] = (object) array(
                  'id' => $c->getId(),
                  'location' => ($root && $c->getParent() ? $c->getParent() : $this->void->getId()),
                  'offsetHeight' => ( $c->getParent()  &&  $c->getParent()->isMovable() ? 1 : 0)
            );
         }
      }
      
      return $update;
   }
   
   public function clientUpdate($userId)
   {
      $player = $this->getPLayerSide($userId);
      $opponent = $this->getOpponentSide($userId);
      
      return self::JSONIndent(json_encode((object) array(
            'update' => $this->getGameStatus()
      )));
   }

   public function clientInitialization($userId)
   {
      $player = $this->getPlayerSide($userId);
      $opponent = $this->getOpponentSide($userId);

      $init = (object) array(
                  'createThis' => (object) array(
                        'void' => (object) array(
                              'id' => $this->void->getId(),
                        ),
                        'player' => (object) array(
                              'hand' => (object) array(
                                    'id' => $player->getHand()->getId(),
                                    'html' => $player->getHand()->getHTML(),
                              ),
                              'playableArea' => (object) array(
                                    'id' => $player->getPlayableArea()->getId(),
                                    'html' => $player->getPlayableArea()->getHTML(),
                              ),
                              'decks' => $player->getDecksInitialization(),
                              'graveyard' => $player->getGraveyard() ? (object) array(
                                          'id' => $player->getGraveyard()->getId(),
                                    ) : null,
                        ),
                        'opponent' => (object) array(
                              'playableArea' => (object) array(
                                    'id' => $opponent->getPlayableArea()->getId(),
                                    'html' => $opponent->getPlayableArea()->getReversedHTML(),
                              )
                        ),
                  ),
            'update' => $this->getGameUpdate(),
      );
      return self::JSONIndent(json_encode($init));
   }

   public static function JSONIndent($json)
   {
      $result = '';
      $pos = 0;
      $strLen = strlen($json);
      $indentStr = '  ';
      $newLine = "\n";
      $prevChar = '';
      $outOfQuotes = true;

      for ($i = 0; $i <= $strLen; $i++)
      {

         // Grab the next character in the string.
         $char = substr($json, $i, 1);

         // Are we inside a quoted string?
         if ($char == '"' && $prevChar != '\\')
         {
            $outOfQuotes = !$outOfQuotes;

            // If this character is the end of an element,
            // output a new line and indent the next line.
         }
         else if (($char == '}' || $char == ']') && $outOfQuotes)
         {
            $result .= $newLine;
            $pos--;
            for ($j = 0; $j < $pos; $j++)
            {
               $result .= $indentStr;
            }
         }

         // Add the character to the result string.
         $result .= $char;

         // If the last character was the beginning of an element,
         // output a new line and indent the next line.
         if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes)
         {
            $result .= $newLine;
            if ($char == '{' || $char == '[')
            {
               $pos++;
            }

            for ($j = 0; $j < $pos; $j++)
            {
               $result .= $indentStr;
            }
         }

         $prevChar = $char;
      }

      return $result;
   }

}