<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    // this will be the first step
    /**
     * @Route("/", name="main")
     */
    // public function index(): Response
    // {
    //     return new Response('<div><h2> Welcome to  this tuturial</h2></div>');
    // }

    /**************************************************************************************************** */

    // En esta ruta necesitamos pasarle un parámetro , pero si después del parámetro ponemos ? 
    // este parámetro no será obligatorio para que renderize la página
    // /**
    //  * @Route("/custom/{name?}",name="custom")
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function custom(Request $request)
    // {
    //     //puede ser que para usar la función dump y server necesitamos requerirla con composer
    //     // composer require symfony/web-server-bundle --dev ^4.4.2 y corremos bin/console server:run
    //     // si ponemos un nombre en el navegador en sustitución de la ? podemos ver en attributes/parametersBag el nombre
    //     dump($request);
    //     return new Response('<div><h2> Welcome </h2></div>');
    // }



    /**************************************************************************************************** */


    // En este caso le decimos que imprima por la consola del navegador el nombre que le pasamos 
    //    /**
    //      * @Route("/custom/{name?}",name="custom")
    //      * @param Request $request
    //      * @return Response
    //      */
    //     public function custom(Request $request)
    //     {
    //         // ahora vamos a usar la función ->get con la que obtenemos el parámetro que le pasamos en el buscador
    //         dump($request->get('name'));
    //         return new Response('<div><h2> Welcome </h2></div>');
    //     }


    /**************************************************************************************************** */

    // Ahora vamos a pintar por pantalla el nombre que le pasemos por parámetro al buscador

    // /**     
    //  * @Route("/custom/{name?}",name="custom")
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function custom(Request $request)
    // {
    //     // ahora vamos a usar la función ->get con la que obtenemos el parámetro que le pasamos en el buscador
    //     $name = ($request->get('name'));
    //     return new Response('<div><h2> Welcome '. $name .' </h2></div>');
    // }

    /************************************************************************************************ */


    // Ahora vamos a empezar a renderizar en el navegador a través de las plantillas twig
    // Estamos renderizando el parámetro que escribimos por el buscador en la plantilla twig
    // /**
    //  * @Route("/custom/{name?}", name="custom")
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function customize(Request $request)
    // {
    //     // Con esta función vamos a saludar a alguien entwig
    //     $name = $request->get('name');
    //     return $this->render('home/custom.html.twig', [
    //         'name' => $name
    //     ]);
    // }
}
