<?php

namespace App\Controller;

use App\Entity\SharedContacts;
use App\Form\SharedContactsType;
use App\Repository\SharedContactsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shared-contacts")
 */
class SharedContactsController extends AbstractController
{
    /**
     * @Route("/", name="shared_contacts", methods={"GET"})
     * @param SharedContactsRepository $sharedContactsRepository
     * @return Response
     */
    public function index(SharedContactsRepository $sharedContactsRepository): Response
    {
        return $this->render('shared_contacts/index.html.twig', [
            'shared_contacts' => $sharedContactsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shared_contacts_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $sharedContact = new SharedContacts();
        $form = $this->createForm(SharedContactsType::class, $sharedContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sharedContact);
            $entityManager->flush();

            return $this->redirectToRoute('shared_contacts');
        }

        return $this->render('shared_contacts/new.html.twig', [
            'shared_contact' => $sharedContact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shared_contacts_show", methods={"GET"})
     * @param SharedContacts $sharedContact
     * @return Response
     */
    public function show(SharedContacts $sharedContact): Response
    {
        return $this->render('shared_contacts/show.html.twig', [
            'shared_contact' => $sharedContact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shared_contacts_edit", methods={"GET","POST"})
     * @param Request $request
     * @param SharedContacts $sharedContact
     * @return Response
     */
    public function edit(Request $request, SharedContacts $sharedContact): Response
    {
        $form = $this->createForm(SharedContactsType::class, $sharedContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shared_contacts');
        }

        return $this->render('shared_contacts/edit.html.twig', [
            'shared_contact' => $sharedContact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="shared_contacts_delete", methods={"DELETE"})
     * @param Request $request
     * @param SharedContacts $sharedContact
     * @return Response
     */
    public function delete(Request $request, SharedContacts $sharedContact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sharedContact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sharedContact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shared_contacts');
    }
}
