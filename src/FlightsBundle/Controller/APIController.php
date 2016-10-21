<?php

namespace FlightsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class APIController extends Controller
{

    private function getAirportsJson()
    {
       $dir = $this->get('kernel')->getRootDir() . '/../src/FlightsBundle/Resources/data/';
       $airports = json_decode(file_get_contents($dir . 'airports.json'), true);

        return $airports;
    }

    private  function getApiToken()
    {

        $clientId = base64_encode("V1:0qna7umbzp5yc7q5:DEVCENTER:EXT");
        $secretId = base64_encode("3rt7EHlC");

        $key = base64_encode("$clientId:$secretId");

        $ch = curl_init('https://api.test.sabre.com/v2/auth/token');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic " . $key,
            "Content-Type: application/x-www-form-urlencoded"
        ));


        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $result = curl_exec($ch);
        $decode = json_decode($result, true);

        if (array_key_exists('error', $decode)){
            throw new Exception($decode['error']);
        }

        if (array_key_exists('access_token', $decode)){
            return $decode['access_token'];
        }

        return null;

    }

    private function resultApi($whereTo)
    {
        $token = $this->getApiToken();

        $ch = curl_init("https://api.test.sabre.com/v1/shop/flights/cheapest/fares/$whereTo");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $token
        ));

        $result = curl_exec($ch);
        $decode = json_decode($result, true);

        return $decode;
    }

    /**
     * @Route("/getApi", name="getApi")
     * @Template("FlightsBundle:API:search.html.twig")
     */
    public function searchAction(Request $request)
    {
        $airports = $this->getAirportsJson();

        return array (
            "airports" => $airports
        );
    }

    /**
     * @Route("/showFlights", name="showFlights")
     * @Template("FlightsBundle:API:showFlights.html.twig")
     * @Method("POST")
     */
    public function showFlightsAction(Request $request)
    {
        $IATAcode = $this->getAirportsJson();

        $whereTo = $request->request->get('airport');
        $result = $this->resultApi($whereTo);

        return array (
            "result" => $result,
            "IATAcode" =>$IATAcode
        );
    }

}
