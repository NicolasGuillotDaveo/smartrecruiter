<?php

//On définit dans $method la méthode d'envoie utilisée
$method= $_SERVER['REQUEST_METHOD'];
//on accepte que si la méthode est "POST"
if($method = "POST"){

	$requestBody= file_get_contents('php://input');
    //on décode le JSON
	$json= json_decode($requestBody);
    //on prend la valeur de l'action
	$text= $json->queryResult->action;
    //on prend la valeur de la réponse que DialogFlow nous propose
    $DFresult= $json->queryResult->fulfillmentText;
    $speech=$DFresult;


	switch($text){

        case 'GetPresentation':
            //on réécrit la réponse de DialogFlow
            $speech= $DFresult;
            break;

		case 'GiveInfo':
            //ici:algorithme recherche d'info de la personne
			$speech= "tu es riadh- bien reçu";//réponse très simple pour l'instant
			break;

		case 'TakeInfo':
            //ici: algorithme qui insère les données dans la BD
            //on réécrit la valeur de DialogFlow qui ici nous convient
			$speech= $DFresult;
			break;

        case 'PrendreRdv':
            //ici: algorithme qui insère les données dans la BD
            //on réécrit la valeur de DialogFlow qui ici nous convient
			$speech=$DFresult;
			break;

        case 'GetNonExp':
            $speech="vous n'avez pas d'expérience, ce n'est pas grave. Dites m'en plus sur vous.";
            break;

		default;
        // si l'action n'est pas connue
			$speech=$DFresult+"héhé";
			break;

	}
    //on créée la réponse
	$response = new \stdClass();
    //on insère le speech dans la réponse
	$response->fulfillmentText = $DFresult;

    //on écrit ici la source de la réponse : ici : webhook
	$response->source= "webhook2";
    //on encode $reponse pour l'avoir au format JSON
	echo json_encode($response);

}else{

	echo "method not allowed";
}





?>
