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

namespace BitExpert\Sulu\SecuritytxtBundle\Controller\Website;

use BitExpert\Sulu\SecuritytxtBundle\Entity\Securitytxt;
use BitExpert\Sulu\SecuritytxtBundle\Repository\SecuritytxtRepository;
use DateTime;
use Sulu\Component\Webspace\Analyzer\Attributes\RequestAttributes;
use Sulu\Component\Webspace\Portal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SecuritytxtWebsiteController extends AbstractController
{
    public function __construct(
        private readonly SecuritytxtRepository $repository
    ) {
    }

    #[Route(path: '.well-known/security.txt', methods: ['GET'])]
    public function getAction(Request $request): Response
    {
        /** @var RequestAttributes|null $sulu */
        $sulu = $request->attributes->get('_sulu', null);
        if ($sulu === null) {
            throw new NotFoundHttpException();
        }

        /** @var Portal|null $webspace */
        $webspace = $sulu->getAttribute('webspace', null);
        if ($webspace === null) {
            throw new NotFoundHttpException();
        }

        $entity = $this->repository->findByWebspaceKey($webspace->getKey());
        if (!$entity instanceof Securitytxt) {
            throw new NotFoundHttpException();
        }

        $content = '';
        try {
            /** @var string $expires */
            $expires = $entity->getExpires();
            $expires = new DateTime($expires);

            $content .= 'Contact: '.$entity->getContact()."\n";
            $content .= 'Expires: '.$expires->format(DateTime::ATOM)."\n";
            if (is_string($entity->getEncryption()) && ($entity->getEncryption() !== '')) {
                $content .= 'Encryption: '.$entity->getEncryption()."\n";
            }
            if (is_string($entity->getAcknowledgments()) && ($entity->getAcknowledgments() != '')) {
                $content .= 'Acknowledgments: '.$entity->getAcknowledgments()."\n";
            }
            if (is_string($entity->getPolicy()) && ($entity->getPolicy() !== '')) {
                $content .= 'Policy: '.$entity->getPolicy()."\n";
            }
            if (is_string($entity->getHiring()) && ($entity->getHiring() !== '')) {
                $content .= 'Hiring: '.$entity->getHiring()."\n";
            }
        } catch (\Exception $e) {
            throw new HttpException(500);
        }

        $response = new Response();
        $response->setContent($content);
        return $response;
    }
}
