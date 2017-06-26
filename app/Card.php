<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    private $category;
    private $value;
    private $numeric_value;
    //Constant qui contient le mapping sign value
    const SIGN_TO_VALUE = array(
        'ACE'   => 1,
        'TWO'   => 2,
        'THREE' => 3,
        'FOUR'  => 4,
        'FIVE'  => 5,
        'SIX'   => 6,
        'SEVEN' => 7,
        'EIGHT' => 8,
        'NINE'  => 9,
        'TEN'   => 10,
        'JACK'  => 11,
        'QUEEN' => 12,
        'KING'  => 13
    );

    //Constructeur par default
    public function __construct($category, $value){
        $this->category = $category;
        $this->value = $value;
        $this->numeric_value = self::SIGN_TO_VALUE[$value];
    }

    /**
     * [getCategory description]
     * @return <String> [category]
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     * Gets the value.
     * @return     <String>  The value.
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * Gets the numeric value.
     *
     * @return     <int>  The numeric value.
     */
    public function getNumericValue(){
        return $this->numeric_value;
    }

    /**
     * Sets the category.
     *
     * @param      <String>  $category  The category
     */
    public function setCategory($category){
        $this->category = $category;
    }

    /**
     * Sets the value.
     *
     * @param      <String>  $value  The value
     */
    public function setValue($value){
        $this->value = $value;
    }

}
