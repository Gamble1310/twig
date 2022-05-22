<?php

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

$data = array();

use GuzzleHttp\Client;



if(isset($_POST['submit']))
{
    $URL = 'https://api.giphy.com/v1/gifs';
    $API_KEY = "yATImQu655t7VCGNLKtfJzMfkPg9DayR";
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => $URL,
        // You can set any number of default request options.
        //'timeout'  => 2.0,
        "verify" => false
    ]);
    $Testo = $_POST['testo'];

    $response = $client->request(
        'GET', 
        $URL . "/search", 
        [
            'query' => ['api_key' => $API_KEY, "q" => $Testo]
            //"images":{"original":{"height":"320","width":"480","size":"752667"}}
        ]
    );
    $code = $response->getStatusCode(); // 200
    
    $data = json_decode(
        $response->getBody()->getContents(),
        true
    );



}

echo $twig->render('form.html.twig', [
    'code' => $code, 
    'data' => $data['data']
    
]);
?>