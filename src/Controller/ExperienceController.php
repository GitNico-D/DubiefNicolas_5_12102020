<?php

namespace App\Controller;

use App\Entity\Experience;
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
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 */
class ExperienceController extends AbstractController
{
    /**
     * GET an Experience resources list
     * 
     * @Route("/experiences", name="get_experience_list", methods={"GET"})
     * 
     * @OA\Tag(name="Experiences")
     * @Security(name="Bearer")
     */
    public function readExperienceList(Request $request, CustomHateoasLinks $customLink): JsonResponse
    {
        $experiences = $this->getDoctrine()
            ->getRepository(Experience::class)
            ->findAll();
        $customLink->createLink($request, $experiences);
        return $this->json($experiences, JsonResponse::HTTP_OK);
    }

    /**
     * GET an Experience resource
     * 
     * @Route("/experiences/{id}", name="get_experience", methods={"GET"})
     * @ParamConverter("experience", class="App:experience")
     * 
     * @OA\Tag(name="Experiences")
     * @Security(name="Bearer")
     */
    public function readExperience(Experience $experience, CustomHateoasLinks $customLink): JsonResponse
    { 
        $links = $customLink->createLink($experience);
        return $this->json([$experience, ['_links' => $links]], JsonResponse::HTTP_OK);
    }

    /**
     * CREATE a new Experience resource
     * 
     * @Route("/experiences", name="create_experiences", methods={"POST"})
     * @ParamConverter("experience", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @OA\Tag(name="Experiences")
     * @Security(name="Bearer")
     */
    public function createExperience(
        Experience $experience,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($experience);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->persist($experience);
            $em->flush();
            return $this->json(
                $experience,
                JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_experience", ["id" => $experience->getId()])]
            );
        }
    }    

    /**
     * UPDATE an existing Experience resource
     * 
     * @Route("/experiences/{id}", name="update_experience", methods={"PUT"})
     * @ParamConverter("experience", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @OA\Tag(name="Experiences")
     * @Security(name="Bearer")
     */
    public function updateExperience(
        Experience $experience,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
        ): JsonResponse
    {       
        $errors = $errorValidator->errorsViolations($experience);
        if ($errors) {
            return$this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->flush($experience);
            return$this->json($experience, JsonResponse::HTTP_OK);
        }
    }
    
    /**
     * DELETE an existing Experience resource
     * 
     * @Route("/experiences/{id}", name="delete_experience", methods={"DELETE"})
     * @ParamConverter("experience", class="App:experience")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @OA\Tag(name="Experiences")
     * @Security(name="Bearer")
     */
    public function deleteExperience(Experience $experience, EntityManagerInterface $em): JsonResponse
    {
        $id = $experience->getId();
        $em->remove($experience);
        $em->flush();
        return $this->json(['Message' => 'Experience id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}