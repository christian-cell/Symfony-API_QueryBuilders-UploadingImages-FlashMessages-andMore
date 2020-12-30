<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
// use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
        // dump($posts);
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }


    /****************************************************************************** */


    // En este bloque vamos a empezar hacer post en la entidad que acabamos de crear Post

    // /**
    //  * @Route("/create", name="create")
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function create(Request $request)
    // {
    //     //llamamos a la entidad y la guardamos dentro de la variable $post 
    //     $post = new Post();
    //     //si reconoce al entidad la importará arriba y podrás accedar a uno métodos entre ellos set
    //     $post->setTitle('This is going to be a description');
    //     //vamos a ver las funciones de entityManager
    //     $em = $this->getDoctrine()->getManager();
    //     $em->persist($post);
    //     $em->flush();
    //     //vamos a usar la función de Response añadiéndola en nuestra ruta también
    //     // return new Response('Post was created');
    //     // o podemos directamente decirle que nos redirija a otra ruta
    //     return $this->redirect($this->generateUrl('post.index'));



    // }
    /****************************************************************************** */


    // Vamos a crear una función solo para mostrar el título

    // /**
    //  * @Route("/show/{id}",name="show")
    //  * @return Response
    //  * 
    //  */
    // public function show($id, PostRepository $postRepository)
    // {
    //     $post = $postRepository->find($id);
    //     //Le decimos die() si todavía no tenemos la vista de post/index.html.twig creada
    //     //dump($post); die();
    //     return $this->render('post/show.index.html.twig', [
    //         'post' => $post
    //     ]);
    // }


    //VAMOS A CREAR UNA FUNCIÓN SHOW PARA LA QUERYBUILDER QUE HEMOS HECHO EN POSTREPOSITORY
    /**
     * @Route("/show/{id}",name="show")
     * @return Response
     * 
     */
    public function show(Post $post)
    {
        
        //Le decimos die() si todavía no tenemos la vista de post/index.html.twig creada
        //dump($post); die();
        return $this->render('post/show.index.html.twig', [
            'post' => $post
        ]);
    }


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

    // /**
    //  * @Route("/show/{id}",name="show")
    //  * @param Post $post
    //  * @return Response
    //  */
    // public function show(Post $post)
    // {
    //     return $this->render('post/show.index.html.twig', [
    //         'post' => $post
    //     ]);
    // }

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

        // $session = new Session();
        // $session->start();

        // $session->getFlashBag()->add(
        //     'success',
        //     'your post was deleted successfully'
        // );
        $this->addFlash('success', 'Post deleted successfully');

        return $this->redirect($this->generateUrl('post.index'));
    }


    /************************************************************************************ */
    //  vamos a realizar post en el form que acabamos de crear
    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request /* este parámetro en caso de usar servicios FileUploader $fileUploader*/ )
    {

        //llamamos a la entidad y la guardamos dentro de la variable $post 
        $post = new Post();
        //si reconoce al entidad la importará arriba y podrás accedar a uno métodos entre ellos set
        $form = $this->createForm(PostType::class, $post);

        //vamos a manejar la peticion
        $form->handleRequest($request);
        $form->getErrors();
        if ($form->isSubmitted() && $form->isValid()) {
            //entity manager
            $em = $this->getDoctrine()->getManager();
            //creamos este comentario de aquí abajo para poder traernos guessClientExtension "no olvidar la importacion arriba"
            /** @var UploadedFile $file */
            $file = $request->files->get('post')['attachment'];

            if ($file) {

 
                //  $file->upladFile($file);



                 $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                 $file->move(
                     //vamos a modificar el archivo target que se encuentra en config/services.yaml y de paso le ponemos la 
                     //donde le decimos que las imágenes se guardarán en public

                     //seteamos como parámetro el nombre de la propiedad que vamos a usar en nuestro .yaml
                     $this->getParameter('uploads_dir'),
                     $filename
                 );

                $post->setImage($filename);
                $em->persist($post);
                $em->flush();
                //IMPORTANTE migrar el cambio de la entidad : bin/console doctrine:schema:update --force
                //para que añada el nuevo campo image a la entidad
            }





            $this->addFlash('success', 'Article Created');

            // $request->getSession()->getFlashBag()->add();

            return $this->redirect($this->generateUrl('post.index'));
        }


        //vamos a ver las funciones de entityManager



        //NECESITAMOS IR A src/controller/Form/PostType.php y seguir añadiendo propiedades al builder

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
