<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Services\CustomHateoasLinks;
use App\Services\ErrorValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ContactController extends AbstractController
{
    /**
     * GET a Contact resource List
     * 
     * @Route("/contacts", name="get_contact_list", methods={"GET"})
     */
    public function readContactList(CustomHateoasLinks $customLink)
    {
        $contacts = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findAll();
        foreach($contacts as $contact)
        {
            $contactsAndLinks [] = $customLink->createLink($contact);
        }
        return $this->json($contactsAndLinks, JsonResponse::HTTP_OK);
    }

    /**
     * GET a Contacts resource
     *  
     * @Route("/contacts/{id}", name="get_contact", methods={"GET"})
     * @ParamConverter("contact", class="App:contact")
     */
    public function readcontacts(Contact $contact, CustomHateoasLinks $customLink)
    {
        $contactAndLinks = $customLink->createLink($contact);
        return $this->json($contactAndLinks, JsonResponse::HTTP_OK, [], ['groups' => 'presentation:read']);
    }

    /**
     * CREATE a new Contact resource
     * 
     * @Route("/contacts", name="create_contact", methods={"POST"})
     * @ParamConverter("contact", converter="create_entity_Converter")
     * @IsGranted("ROLE_ADMIN")
     */
    public function createContact(
        Contact $contact,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($contact);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $em->persist($contact);
            $em->flush();
            return $this->json(
                $contact,
                JsonResponse::HTTP_CREATED,
                ["Location" => $this->generateUrl("get_contact", ["id" => $contact->getId()])],
                ['groups' => 'presentation:read']
            );
        }
    }

    /**
     * UPDATE an existing Contact resource
     * 
     * @Route("/contacts/{id}", name="update_contact", methods={"PUT"})
     * @ParamConverter("contact", converter="update_entity_converter")
     * @IsGranted("ROLE_ADMIN")
     */
    public function updateContact(
        Contact $contact,
        EntityManagerInterface $em,
        ErrorValidator $errorValidator,
        CustomHateoasLinks $customLink
    ): JsonResponse {
        $errors = $errorValidator->errorsViolations($contact);
        if ($errors) {
            return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
        } else {
            $contactAndLinks = $customLink->createLink($contact);
            $em->flush($contact);
            return $this->json($contactAndLinks, JsonResponse::HTTP_OK);
        }
    }

    /**
     * DELETE an existing Contact resource
     * 
     * @Route("/contacts/{id}", name="delete_contact", methods={"DELETE"})
     * @ParamConverter("contact", class="App:contact")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteContact(Contact $contact, EntityManagerInterface $em)
    {
        $id = $contact->getId();
        $em->remove($contact);
        $em->flush();
        return $this->json(['Message' => 'Contact id ' . $id . ' deleted'], JsonResponse::HTTP_OK);
    }
}