<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */

class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll();
        dump($posts);
        return $this->render('post/index.html.twig', [
           'posts' => $posts
        ]);
    }


 /****************************************************************************** */


    // En este bloque vamos a empezar hacer post en la entidad que acabamos de crear Post

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        //llamamos a la entidad y la guardamos dentro de la variable $post 
        $post = new Post();
        //si reconoce al entidad la importará arriba y podrás accedar a uno métodos entre ellos set
        $post->setTitle('This is going to be a description');
        //vamos a ver las funciones de entityManager
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        //vamos a usar la función de Response añadiéndola en nuestra ruta también
        return new Response('Post was created');
    }
 /****************************************************************************** */
}
