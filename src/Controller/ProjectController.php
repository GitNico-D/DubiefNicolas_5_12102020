<?php

namespace App\Controller;

use App\Entity\Project;
use App\Services\CustomHateoasLinks;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/api")
 */
class ProjectController extends AbstractController
{
    /**
     * GET a Project resources list
     * 
     * @Route("/projects", name="get_project_list", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Return the Projects list",
     *     @Model(type=Project::class)
     * )
     * @OA\Tag(name="Projects")
     * @Security(name="Bearer")
     */
    public function readProjectList(CustomHateoasLinks $customLink): JsonResponse
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();
        foreach($projects as $project)
        {
            $links = $customLink->createLink($project);
            $data [] = [$project, $links];
        }
        return $this->json($data, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Project resource
     * 
     * @Route("/projects/{id}", name="get_project", methods={"GET"})
     * @ParamConverter("project", class="App:project")
     * @OA\Response(
     *     response=200,
     *     description="Return a resource Project by his id",
     *     @Model(type=Project::class)
     * )
     * @OA\Tag(name="Projects")
     * @Security(name="Bearer")
     */
    public function readProject(Project $project, CustomHateoasLinks $customLink): JsonResponse
    {
        $links = $customLink->createLink($project);
        return $this->json([$project, ['_links' => $links]], JsonResponse::HTTP_OK);
    }
    
    /**
     * CREATE a new Project resource
     * 
     * @Route("/projects", name="create_project", methods={"POST"})
     * @ParamConverter("project", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * @OA\Response(
     *     response=201,
     *     description="Create a new resource Project",
     *     @Model(type=Project::class)
     * )
     * @OA\Tag(name="Projects")
     * @Security(name="Bearer")
     */
    public function createProject(
        Project $project,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($project);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->persist($project);
            $em->flush();
            return $this->json(
                $project,
                JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_project", ["id" => $project->getId()])]
            );
        }
    }

    /**
     * UPDATE an existing Project resource
     * 
     * @Route("/projects/{id}", name="update_project", methods={"PUT"}) 
     * @ParamConverter("project", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     * @OA\Response(
     *     response=200,
     *     description="Update an existing resource Project",
     *     @Model(type=Project::class)
     * )
     * @OA\Tag(name="Projects")
     * @Security(name="Bearer")
     */
    public function updateProject(
        Project $project,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($project);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $links = $customLink->createLink($project);
            $em->flush();
            return $this->json([$project, ['_links' => $links]], JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Project resource
     * 
     * @Route("/projects/{id}", name="delete_project", methods={"DELETE"})
     * @ParamConverter("project", class="App:project")
     * @IsGranted("ROLE_ADMIN")
     * @OA\Response(
     *     response=200,
     *     description="Delete an existing resoure Project",
     *     @Model(type=Project::class)
     * )
     * @OA\Tag(name="Projects")
     * @Security(name="Bearer")
     * 
     * @param Project $project
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function deleteProject(Project $project, EntityManagerInterface $em): JsonResponse
    {
        $id = $project->getId();
        $em->remove($project);
        $em->flush();
        return $this->json(['Message' => 'Project id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}