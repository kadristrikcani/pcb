<?php

namespace App\Controller;

use RuntimeException;
use Exception;
use App\Form\AddressContactFormType;
use App\Form\AddressFormType;
use App\Form\ContactType;
use App\Repository\RequestRepository;
use App\Form\CashOfferType;
use App\Service\PodioService;
use App\Entity\Request as RequestEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $formAction = $this->generateUrl('app_address_form') . '?' . $request->getQueryString();
        $contactFormAction = $this->generateUrl('app_address_contact_form') . '?' . $request->getQueryString();

        $form = $this->createForm(AddressFormType::class, null, ['action' => $formAction]);
        $contactForm = $this->createForm(AddressContactFormType::class, null, ['action' => $contactFormAction]);

        return $this->render('home/index.html.twig', [
            'address_form' => $form->createView(),
            'address_contact_form' => $contactForm->createView(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/address-form', name: 'app_address_form')]
    public function addressForm(Request $request, EntityManagerInterface $entityManager, PodioService $podioService): Response
    {
        $queryString = $request->getQueryString();
        $requestData = Request::createFromGlobals();
        if ($request->isXmlHttpRequest()) {
            $requestEntity = new RequestEntity;
            $form = $this->createForm(AddressFormType::class, $requestEntity, ['action' => $this->generateUrl('app_address_form')]);
            if ($request->isMethod('post')) {
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        $requestEntity->setUtmData($queryString);
                        $requestEntity->setIp($requestData->getClientIp());
                        $requestEntity->setPartialConversion(1);
                        $podioItemId = $podioService->sendResponse($requestEntity);
                        $requestEntity->setPodioId($podioItemId);
                        $entityManager->persist($requestEntity);
                        $entityManager->flush();
                    } else {
                        $errors = $form->getErrors(true);
                        $errorMessage = $errors[count($errors) - 1]->getMessage();
                        $this->addFlash('error', $errorMessage);
                    }
                    return $this->redirectToRoute('app_form', ['id' => $requestEntity->getId()]);
                }
            }
        }

        throw new RuntimeException('Error with query!');
    }

    /**
     * @throws Exception
     */
    #[Route('/address-contact-form', name: 'app_address_contact_form')]
    public function addressContactForm(Request $request, EntityManagerInterface $entityManager, PodioService $podioService): Response
    {
        $queryString = $request->getQueryString();
        $requestData = Request::createFromGlobals();

        if ($request->isXmlHttpRequest()) {
            $requestEntity = new RequestEntity;
            $form = $this->createForm(AddressContactFormType::class, $requestEntity, ['action' => $this->generateUrl('app_address_contact_form')]);
            if ($request->isMethod('post')) {
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        $requestEntity->setUtmData($queryString);
                        $requestEntity->setIp($requestData->getClientIp());
                        $requestEntity->setPartialConversion(1);
                        $podioItemId = $podioService->sendResponse($requestEntity);
                        $requestEntity->setPodioId($podioItemId);
                        $entityManager->persist($requestEntity);
                        $entityManager->flush();
                    } else {
                        $errors = $form->getErrors(true);
                        $errorMessage = $errors[count($errors) - 1]->getMessage();
                        $this->addFlash('error', $errorMessage);
                    }
                    return $this->redirectToRoute('app_form_contact', ['id' => $requestEntity->getId()]);
                }
            }
        }

        throw new RuntimeException('Error with query!');
    }

    /**
     * @throws Exception
     */
    #[Route('/form/{id}', name: 'app_form', requirements: ['id' => '\d+'])]
    public function form(int $id, Request $request, EntityManagerInterface $entityManager, RequestRepository $requestRepository, PodioService $podioService): Response
    {
        if ($request->isXmlHttpRequest()) {
            $requestEntity = $requestRepository->findOneBy(['id' => $id]);
            $form = $this->createForm(CashOfferType::class, $requestEntity, ['action' => $this->generateUrl('app_form', ['id' => $id])]);
            if ($request->isMethod('post')) {
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        $requestEntity->setPartialConversion(2);
                        $entityManager->flush();
                        $podioResponse = $podioService->updatePodioItem($requestEntity);
                        $this->addFlash('success', 'Submitted successfully! Your request number: ' . $podioResponse);
                    } else {
                        $errors = $form->getErrors(true);
                        $errorMessage = $errors[count($errors) - 1]->getMessage();
                        $this->addFlash('error', $errorMessage);
                    }
                }
            }
            return $this->render('home/form.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        throw new RuntimeException('Error with query!');
    }


    /**
     * @throws Exception
     */
    #[Route('/form-contact/{id}', name: 'app_form_contact', requirements: ['id' => '\d+'])]
    public function formContact(int $id, Request $request, EntityManagerInterface $entityManager, RequestRepository $requestRepository, PodioService $podioService): Response
    {
        if ($request->isXmlHttpRequest()) {
            $requestEntity = $requestRepository->findOneBy(['id' => $id]);
            $form = $this->createForm(ContactType::class, $requestEntity, ['action' => $this->generateUrl('app_form_contact', ['id' => $id])]);
            if ($request->isMethod('post')) {
                $form->handleRequest($request);
                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        $requestEntity->setPartialConversion(2);
                        $entityManager->flush();
                        $podioResponse = $podioService->updatePodioItem($requestEntity);
                        $this->addFlash('success', 'Submitted successfully! Your request number: ' . $podioResponse);
                    } else {
                        $errors = $form->getErrors(true);
                        $errorMessage = $errors[count($errors) - 1]->getMessage();
                        $this->addFlash('error', $errorMessage);
                    }
                }
            }
            return $this->render('home/contact_form.html.twig', [
                'contact_form' => $form->createView(),
            ]);
        }
        throw new RuntimeException('Error with query!');
    }
}