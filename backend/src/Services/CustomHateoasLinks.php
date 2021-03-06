<?php

namespace App\Services;

use ReflectionClass;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Creating custom Hateoas Links
 */
class CustomHateoasLinks
{
    private $urlGenerator;
    private $routerInterface;
    private $serializer;

    /**
     *
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator, 
        RouterInterface $routerInterface, 
        SerializerInterface $serializer)
    {
        $this->urlGenerator = $urlGenerator;
        $this->routerInterface = $routerInterface;
        $this->serializer = $serializer;
    }

    /**
     * Return the created links
     */
    public function createLink($entity)
    {
        $links = ["_links" => $this->generateLinks($this->routesList($this->getEntityName($entity)), $entity)];
        return $this->createObjectWithLinks($entity, $links);
    }

    /**
     * Return the name of the entity
     */
    public function getEntityName($entity) 
    {
        $reflectionEntity = new ReflectionClass($entity);
        return strtolower($reflectionEntity->getShortName());
    }

    /**
     * Transform Entity on an array and merge links on this arrayEntity
     */
    public function createObjectWithLinks($entity, array $links)
    {   
        if ($this->getEntityName($entity) === "category" || $this->getEntityName($entity) === "skill" || $this->getEntityName($entity) === "software") {
            $entityArray = json_decode($this->serializer->serialize($entity, 'json', ['groups' => 'category:read']), true );
        } elseif ($this->getEntityName($entity) === "contact" || $this->getEntityName($entity) === "presentation") {
            $entityArray = json_decode($this->serializer->serialize($entity, 'json', ['groups' => 'presentation:read']), true );
        } else {
            $entityArray = json_decode($this->serializer->serialize($entity, 'json'), true );
        }
        return array_merge($entityArray, $links);
    }

    /**
     * Listing Routes corresponding to Read, Update and Delete methods of an entity controller
     */
    public function routesList(string $entityName)
    {
        $allRoutes = $this->routerInterface->getRouteCollection()->all();
        foreach ($allRoutes as $route => $params) {
            $controllersList = $params->getDefaults();
            if (isset($controllersList['_controller'])) {
                $controllerAction = explode("::", $controllersList['_controller']);
                if (!str_contains($controllerAction[0], "nelmio")) {
                    $action = $controllerAction[1];
                    if ((!str_contains($action, "List")) && (!str_contains($action, "create"))) {
                        if (str_contains($route, $entityName)) {
                            $routesList [] = $route;
                        } 
                    }
                }
            }
        }
        return $routesList;
    }

    /**
     * Create the list of link corresponding to route and entity
     */
    public function generateLinks(array $routesController, $entity)
    {
        $linksList = [];
        foreach ($routesController as $routeController) {
            $href = $this->urlGenerator->generate(
                $routeController,
                ["id" => $entity->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            if (str_contains($routeController, "get")) {
                $linksList["self"] = ["href" => $href];
            } elseif (str_contains($routeController, "update")) {
                $linksList["udapte"] = ["href" => $href];
            } elseif (str_contains($routeController, "delete")) {
                $linksList["delete"] = ["href" => $href];
            }
        }
        return $linksList;
    }
}