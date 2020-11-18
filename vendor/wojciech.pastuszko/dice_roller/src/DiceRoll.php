<?php namespace diceRoller;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author yourname
*/
class DiceRoll{

   /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
   private $m_SampleProperty = '';

  /**
  * Sample method
  *
  * Always create a corresponding docblock for each method, describing what it is for,
  * this helps the phpdocumentator to properly generator the documentation
  *
  * @param string $param1 A string containing the parameter, do this for each parameter to the function, make sure to make it descriptive
  *
  * @return string
  */
   public function showRoll($param1){
         // return ' Hello my '.$param1.' World!';
         // return __DIR__;
         define("ROLL_PATH", "../vendor/wojciech.pastuszko/dice_roller");

         // echo ROLL_PATH;
         // echo view('home');
         // $json = file_get_contents(ROLL_PATH, true);
         require __DIR__.'/../home.php';
   }
}