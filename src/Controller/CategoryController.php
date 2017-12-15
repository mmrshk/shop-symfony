<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 05.12.2017
 * Time: 19:32
 */

namespace App\Controller;


use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{id}/{page}", name="category_show", requirements={"page":"\d+"})
     *
     * @param Category $category
     * @param $page
     * @param $session
     *
     * @return Response
     */
     public function show(Category $category, $page = 1, SessionInterface $session)
      {
          $session->set('lastVisitedCategory',$category->getId());

          return $this->render(
              'category/show.html.twig',
              ['category'=>$category, 'page'=>$page]);
      }

    /**
    * @Route("message", name="category_message")
     */
    public function message(SessionInterface $session)
    {
        $this->addFlash('notice','Successfully aded');
        $lastCategory = $session->get('lastVisitedCategory');
        return $this->redirectToRoute('category_show',['slug'=>$session->get('lastVisitedCategory')]);
    }
    /**
     * @Route("download", name="category_download")
     */
    public function fileDownload()
    {
        $response = new Response();
        $response->setContent('Test content');
        return $response;
    }
    /**
     * @Route("/categories",name="categories_list")
     *
     */
    public function listCategories()
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);

        $categories = $repo->findAll();

        if(!$categories)
        {
            throw $this->createNotFoundException('Categories not found');
        }
        return $this->render('category/list.html.twig',['categories'=> $categories]);

    }
}