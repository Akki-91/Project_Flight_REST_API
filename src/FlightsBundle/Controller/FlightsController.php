<?php

namespace FlightsBundle\Controller;

use FlightsBundle\Entity\Flights;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $fromLocation = $request->request->get('fromLocation');
        $currency = $request->request->get('currency');
        $price = $request->request->get('price');
        $href = $request->request->get('href');

        $repository = $this->getDoctrine()->getRepository("FlightsBundle:Flights");
        $exists = $repository->findByHref($href, $user);

        if (!!$exists){
            return new Response("<html><body><script>window.close();</script></body></html>");
        }

        $newFlight->setDestination($destination);
        $newFlight->setFromLocation($fromLocation);
        $newFlight->setCurrency($currency);
        $newFlight->setPrice($price);
        $newFlight->setHref($href);
        $newFlight->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newFlight);
        $em->flush();

        return new JsonResponse(array(
            'user' => $user,
            'destination' => $destination,
            'fromLocation' => $fromLocation,
            'currency' => $currency,
            'price' => $price,
            'href' => $href
        ));

    }

    /**
     * @Route("/deleteFlight", name="deleteFlight")
     * @Template("FlightsBundle:API:deleteFlight.html.twig")
     */
    public function deleteFlightAction(Request $request)
    {
        //$user = $this->getUser();
        $id = $request->request->get('id');

        $repository = $this->getDoctrine()->getRepository("FlightsBundle:Flights");
        $deleted = $repository->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($deleted);
        $em->flush();

//        $redirect = $this->redirectToRoute("observed");
//        return new Response("<html><body>$redirect<script>window.opener.close();</script></body></html>");

        return new JsonResponse(array(
            'id' => $id
        ));
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
