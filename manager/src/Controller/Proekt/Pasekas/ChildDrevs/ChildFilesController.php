<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildDrevs;

//use App\Model\Work\Entity\PlemMatkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Files;

use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Executor;
//use App\Model\Adminka\UseCase\Matkas\ChildDrev\Move;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Plan;

//use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\Filter;
//use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\ChildSideFetcher;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\PlemSideFetcher;
use App\Security\Voter\Adminka\Matkas\ChildMatkaAccess;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use App\Service\Uploader\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildFilesController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/{id}/files", name=".files")
     * @param ChildDrev $childmatka
     * @param Request $request
     * @param Files\Add\Handler $handler
     * @param FileUploader $uploader
     * @return Response
     */
    public function files( Request $request, Files\Add\Handler $handler, ChildDrev $childmatka, FileUploader $uploader): Response
    {
//        $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);

        $command = new Files\Add\Command($this->getUser()->getId(),$childmatka->getId()->getValue() );

        $form = $this->createForm(Files\Add\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = [];
            foreach ($form->get('files')->getData() as $file) {

                $uploaded = $uploader->upload($file);
                $files[] = new Files\Add\File(
                    $uploaded->getPath(),
                    $uploaded->getName(),
                    $uploaded->getSize()
                );

            }
            $command->files = $files;

            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/childmatkas/files.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/files/{file_id}/delete", name=".files.delete", methods={"POST"})
     * @ParamConverter("uchastie", options={"id" = "uchastie_id"})
     * @param ChildDrev $childmatka
     * @param string $file_id
     * @param Request $request
     * @param Files\Remove\Handler $handler
     * @return Response
     */
    public function fileDelete(ChildDrev $childmatka, string $file_id, Request $request, Files\Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('revoke', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);

        $command = new Files\Remove\Command($this->getUser()->getId(), $childmatka->getId()->getValue(), $file_id);

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }



}


