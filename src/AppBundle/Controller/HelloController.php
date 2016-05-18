<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HelloController {

    /**
     * @Route("/hello/{name}", name="hello", defaults={"name": "Default name"},)
     */
    public function indexAction($name) {
        return new Response('<html><body>Hello ' . $name . '!</body></html>');
    }

}
