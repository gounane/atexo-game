<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Card;
use \App\Http\Utilities\Utility;


class CardsController extends Controller
{
	static $cards_list = array(
        'DIAMOND' => array(),
        'HEART' => array(),
        'SPADE' => array(),
        'CLUB' => array()
    );

	/**
	 *  action /cards
	 *  Afficher les cartes trièes par catégories et par valeurs
	 */
	public function index(){

		//params init
		$url = 'https://recrutement.local-trust.com/test/cards/57187b7c975adeb8520a283c';
		$data = array();
		$exerciceId = $json = "";

		//check if request return data
		if(Utility::getHttpResponseCode($url) == "200"){
		    $str = file_get_contents($url);
		    $array = json_decode($str);
		    if(isset($array->data) && !empty($array->data->cards)){
		    	$cards = $array->data->cards;
		    	$list = array();
		    	foreach ($cards as $item) {
		    		$card = new Card($item->category, $item->value);
		    		$list = $this->addCardToCategory($card);
		    	}
		    	$data = self::sortList($list);	
		    	$exerciceId = $array->exerciceId;	
		    	$json = self::prepareJsonCards($data);
		    }
		}
		return view('cards.index', compact('data', 'json', 'exerciceId'));
	}
    
    public function check(Request $request){
    	//check if ajax request
    	if($request->ajax()) {
    		//get data send by ajax post
			$json_to_send = $request->all()['json_to_send'];
			$exerciceId = $request->all()['exerciceId'];                                                                                   
			                                                                                                                     
			$ch = curl_init('https://recrutement.local-trust.com/test/'.$exerciceId);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_to_send);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',                                                     
				    'Content-Length: ' . strlen($json_to_send)
			    )                                                                 
			);                                                 
			$result = curl_exec($ch);
			$info = curl_getinfo($ch);
			return $info['http_code'];
    	}
    }


	/**
	 * Adds a card to category.
	 *
	 * @param      <Card>  $card   The card
	 *
	 * @return     <array> arry of card by category
	 */
	public static function addCardToCategory($card){
        array_push(self::$cards_list[$card->getCategory()], $card);
        return self::$cards_list;
    }

    /**
     * Trie les cartes par valeur numeric
     *
     * @param      <array>  $list   The list card
     *
     * @return     <array>  
     */
    public static function sortList($list)
    {
        foreach ($list as $key => $value) {
 			usort($value, function ($a, $b) {
	           return ($a->getNumericValue() > $b->getNumericValue());
	        });
        	$list[$key] = $value;
        }
        return $list;
    }
    /**
     * Prepare Json to send to https://recrutement.local-trust.com/test/{exerciceId}
     *
     * @param      <Array>  $list   The list
     *
     * @return     <String>  ( Json )
     */
    public static function prepareJsonCards($list)
    {
    	$data = array(
    		'cards' => array(),
    		'categoryOrder' => array("DIAMOND","HEART","SPADE","CLUB"),
    		'valueOrder'    => array("ACE","TWO","THREE","FOUR","FIVE","SIX","SEVEN","EIGHT","NINE","TEN","JACK","QUEEN","KING")
    	);
    	foreach ($list as $category => $cards) {
    		foreach ($cards as $card) {
    			$data['cards'][] = array(
    				'category' => $category,
    				'value'    => $card->getValue()
    			);
    		}
    	}
    	return json_encode($data);
    }
}
