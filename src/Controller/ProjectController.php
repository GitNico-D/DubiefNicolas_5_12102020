<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/projects", name="get_project_list", methods={"GET"})
     */
    public function readProjectList(SerializerInterface $serializer)
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        $data = $serializer->serialize($projects, 'json');

        $response = new Response($data);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     */
    public function readProject($id, SerializerInterface $serializer)
    {
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($id);
        $data = $serializer->serialize($project, 'json');

        $response = new Response($data);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/projects", name="create_project", methods={"POST"})
     */
    public function createProject(
        Request $request, 
        SerializerInterface $serializer, 
        UrlGeneratorInterface $urlGenerator
        ): Response
    {
        $project = $serializer->deserialize($request->getContent(), Project::class, 'json');
        
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($project);
        $entityManager->flush();

        $response = new Response(
            $serializer->serialize($project, 'json'), 
            Response::HTTP_CREATED,
            ["Location" => $urlGenerator->generate("get_project", ["id" => $project->getId()])]
        );

        return $response;
    }

    /**
     * @Route("/projects/{id}", name="update_project", methods={"PUT"})
     */
    public function updateProject($id, Request $request, SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $project = $this->getDoctrine()->getRepository(Project::class)->find($id);
        $serializer->deserialize($request->getContent(), Project::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $project]);
        
        $entityManager->flush($project); 

        $response = new Response($serializer->serialize($project, 'json'), Response::HTTP_NO_CONTENT);

        return $response;
    }
}
