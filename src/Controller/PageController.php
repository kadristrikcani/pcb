<?php

namespace App\Controller;

use App\Form\AddressContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    private const ALLOWED_PAGES = ['cash', 'damaged', 'divorce', 'inherited', 'tenant', 'agent'];

    #[Route('/page/{page}', name: 'app_page', requirements: ['page' => 'cash|damaged|divorce|inherited|tenant|agent'])]
    public function page(Request $request, string $page): Response
    {
        $contactFormAction = $this->generateUrl('app_address_contact_form') . '?' . $request->getQueryString();
        $contactForm = $this->createForm(AddressContactFormType::class, null, ['action' => $contactFormAction]);

        if (!in_array($page, self::ALLOWED_PAGES, true)) {
            throw $this->createNotFoundException("Page '$page' not found.");
        }

        return $this->render("page/{$page}.html.twig", [
            'address_contact_form' => $contactForm->createView(),
        ]);
    }

}