<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

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
        $post->setTitle('This is going to be a title');
        //vamos a ver las funciones de entityManager
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        //vamos a usar la función de Response añadiéndola en nuestra ruta también
        // return new Response('Post was created');
        // o podemos directamente decirle que nos redirija a otra ruta
        return $this->redirect($this->generateUrl('post.index'));
    }
    /****************************************************************************** */


    // Vamos a crear una función solo para mostrar el título

    // /**
    //  * @Route("/show/{id}",name="show")
    //  * @return Response
    //  * 
    //  */
    // public function show($id , PostRepository $postRepository)
    // {
    //     $post = $postRepository->find($id);
    //     //Le decimos die() si todavía no tenemos la vista de post/index.html.twig creada
    //     dump($post); die();
    //     return $this->render('post/index.html.twig', [
    //         'post' => $post
    //     ]);


    //Esta será la respuesta en el post/index.html.twig
    //     //   <td>
    // 	// 						{{post.id}}
    // 	// 					</td>
    // 	// 					<td>
    // 	// 						<a href="{{ path("post.show" , {id: post.id}) }}">
    // 	// 							{{ post.title }}
    // 	// 						</a>
    // 	// 					</td>
    // }

    /************************************************************************************************** */

    //Vamos a renderizar algún elemento de la lista a través de su id en post/show.index.html.twig

    /**
     * @Route("/show/{id}",name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        return $this->render('post/show.index.html.twig', [
            'post' => $post
        ]);
    }

    /********************************************************************************************************* */

    //vamos a hacer alguna ruta para poder borrar alguna entrada , ahora cuando introduzcamos en el buscador /post/delete/con un id
    //se ejecutará la acción de borrar una entrada

    /**
     * @Route("/delete/{id}" , name="delete")
     * @param Post
     * @return Response
     */

    public function remove(Post $post)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        //vamos a añadir algún mensaje cuando borremos algún item
        // $session = $this->getRequest()->getSession();
        
        // $this->addFlash('success','Post deletes successfully');

        return $this->redirect($this->generateUrl('post.index'));
    }
}
