<?php
/*
 * This file is part of the Sulu Securitytxt bundle.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\Sulu\SecuritytxtBundle\Controller\Admin;

use BitExpert\Sulu\SecuritytxtBundle\Common\DoctrineListRepresentationFactory;
use BitExpert\Sulu\SecuritytxtBundle\Entity\Securitytxt;
use BitExpert\Sulu\SecuritytxtBundle\Repository\SecuritytxtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @phpstan-type SecuritytxtData array{
 *     id: int|null,
 *     webspace_key: string|null,
 *     contact: string,
 *     expires: string,
 *     encryption: string|null,
 *     acknowledgments: string|null,
 *     policy: string|null,
 *     hiring: string|null,
 * }
 */
class SecuritytxtAdminController extends AbstractController
{
    public function __construct(
        private readonly SecuritytxtRepository $repository,
        private readonly DoctrineListRepresentationFactory $doctrineListRepresentationFactory,
    ) {
    }

    #[Route(path: 'securitytxt/{id}', name: 'bitexpert.get_securitytxt', methods: ['GET'])]
    public function getAction(int $id): Response
    {
        $entity = $this->repository->findById($id);
        if (!$entity instanceof Securitytxt) {
            throw new NotFoundHttpException();
        }

        return $this->json($this->getDataForEntity($entity));
    }

    #[Route(path: 'securitytxt/{id}', name: 'bitexpert.put_securitytxt', methods: ['PUT'])]
    public function putAction(int $id, Request $request): Response
    {
        $entity = $this->repository->findById($id);
        if (!$entity instanceof Securitytxt) {
            throw new NotFoundHttpException();
        }

        /** @var SecuritytxtData $data */
        $data = $request->toArray();
        $this->mapDataToEntity($data, $entity);

        $this->repository->save($entity);

        return $this->json($this->getDataForEntity($entity));
    }

    #[Route(path: 'securitytxt', name: 'bitexpert.post_securitytxt', methods: ['POST'])]
    public function postAction(Request $request): Response
    {
        $entity = $this->repository->create();

        /** @var SecuritytxtData $data */
        $data = $request->toArray();
        $data['webspace_key'] = $request->get('webspace');
        $this->mapDataToEntity($data, $entity);

        $this->repository->save($entity);

        return $this->json($this->getDataForEntity($entity), 201);
    }

    #[Route(path: 'securitytxt/{id}', name: 'bitexpert.delete_securitytxt', methods: ['DELETE'])]
    public function deleteAction(int $id): Response
    {
        $this->repository->remove($id);

        return $this->json(null, 204);
    }

    #[Route(path: 'securitytxt', name: 'bitexpert.get_securitytxt_list', methods: ['GET'])]
    public function getListAction(): Response
    {
        $listRepresentation = $this->doctrineListRepresentationFactory->createDoctrineListRepresentation(
            Securitytxt::RESOURCE_KEY,
        );

        return $this->json($listRepresentation->toArray());
    }

    /**
     * @return SecuritytxtData
     */
    protected function getDataForEntity(Securitytxt $entity): array
    {
        return [
            'id' => $entity->getId(),
            'webspace_key' => $entity->getWebspaceKey(),
            'contact' => $entity->getContact() ?? '',
            'expires' => $entity->getExpires() ?? '',
            'encryption' => $entity->getEncryption() ?? '',
            'acknowledgments' => $entity->getAcknowledgments() ?? '',
            'policy' => $entity->getPolicy() ?? '',
            'hiring' => $entity->getHiring() ?? '',
        ];
    }

    /**
     * @param SecuritytxtData $data
     */
    protected function mapDataToEntity(array $data, Securitytxt $entity): void
    {
        $entity->setWebspaceKey($data['webspace_key']);
        $entity->setContact($data['contact']);
        $entity->setExpires($data['expires']);
        $entity->setEncryption($data['encryption'] ?? '');
        $entity->setAcknowledgments($data['acknowledgments'] ?? '');
        $entity->setPolicy($data['policy'] ?? '');
        $entity->setHiring($data['hiring'] ?? '');
    }
}
