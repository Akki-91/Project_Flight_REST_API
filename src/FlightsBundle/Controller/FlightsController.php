<?php

namespace FlightsBundle\Controller;

use FlightsBundle\Entity\Flights;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class FlightsController extends Controller
{
    /**
     * @Route("/saveFlight", name="saveFlight")
     * @Template("FlightsBundle:API:saveFlight.html.twig")
     */
    public function saveFlightAction(Request $request)
    {
        $user = $this->getUser();
        $newFlight = new Flights();

        $destination = $request->request->get('destination');
        $from = $request->request->get('from');
        $currency = $request->request->get('currency');
        $price = $request->request->get('price');
        $href = $request->request->get('href');


        $repository = $this->getDoctrine()->getRepository("FlightsBundle:Flights");
        $exists = $repository->findByHref($href, $user);

        if (!!$exists){
            return new Response("<html><body><script>window.close();</script></body></html>");
        }

        $newFlight->setDestination($destination);
        $newFlight->setFromLocation($from);
        $newFlight->setCurrency($currency);
        $newFlight->setPrice($price);
        $newFlight->setHref($href);
        $newFlight->setUser($user);

        dump($newFlight);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newFlight);
        $em->flush();

        return new Response("<html><body><script>window.close();</script></body></html>");

    }

    /**
     * @Route("/observed", name="observed")
     * @Template("FlightsBundle:API:observedFlight.html.twig")
     */
    public function observedAction()
    {
        $user = $this->getUser();

        $repository = $this->getDoctrine()->getRepository("FlightsBundle:Flights");
        $observed = $repository->findByUser($user);

        return array(
            "observed" => $observed
        );
    }

}
