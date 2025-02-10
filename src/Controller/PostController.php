<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\FileUploader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;



#[Route('/post', name: 'post.')]
final class PostController extends AbstractController
{
    private PostRepository $postRepository;
    private EntityManagerInterface $em;
    private FileUploader $fileUploader;

    public function __construct(PostRepository $postRepository, EntityManagerInterface $em, FileUploader $fileUploader)
    {   
        $this->postRepository = $postRepository;
        $this->em = $em;
        $this->fileUploader = $fileUploader;
        
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $post = $this->postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $post
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function display(int $id)
    {
        $post = $this->postRepository->findPostByIdWithCategory($id);
        // $post = $this->postRepository->find($id);
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }
    
        return $this->render('post/show.html.twig', ['post' => reset($post)]);
    }

    #[Route('/create', name: 'create_post')]
    public function create(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            
            $file = $request->files->get('post')['attachment'];
            if ($file) {
                $fileName = $this->fileUploader->uploadFile($file);
                $post->setImgSrc($fileName);
            }

            $this->em->persist($post);
            $this->em->flush();
            $this->addFlash('success.post', "Successfully Added");

            return $this->redirectToRoute('post.index');
        }

        return $this->render('post/create.html.twig', [
            'form' =>$form->createView()
        ]);

        
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function remove($id): Response
    {
        $post = $this->postRepository->find($id);
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        $this->em->remove($post);
        $this->em->flush();

        $this->addFlash('success.post', "Post was removed");
        return $this->redirect($this->generateUrl('post.index'));
    }


}
