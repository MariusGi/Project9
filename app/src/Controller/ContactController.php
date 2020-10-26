<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\SharedContactsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contacts")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contacts", methods={"GET"})
     * @param ContactRepository $contactRepository
     * @param SharedContactsRepository $sharedContactsRepository
     * @return Response
     */
    public function index(ContactRepository $contactRepository, SharedContactsRepository $sharedContactsRepository): Response
    {
        $userId = $this->getUser()->getId();
        $sharedContactsArr = array_column($sharedContactsRepository->findBySharedToAndReturnContactId($userId), 'contact_id');

        return $this->render('contacts/index.html.twig', [
            'contacts' => $contactRepository->findBy([
                'user_id_saved_to' => $userId,
            ]),
            'shared_contacts' => $contactRepository->findBy([
                'id' => $sharedContactsArr,
            ]),
        ]);
    }

    /**
     * @Route("/new", name="contact_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $userId = $this->getUser()->getId();

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact, [
            'user_id_saved_to' => $userId,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contacts');
        }

        return $this->render('contacts/new.html.twig', [
            'contacts' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_show", methods={"GET"})
     * @param Contact $contact
     * @return Response
     */
    public function show(Contact $contact): Response
    {
        return $this->render('contacts/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Contact $contact
     * @return Response
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $userId = $this->getUser()->getId();

        $form = $this->createForm(ContactType::class, $contact, [
            'user_id_saved_to' => $userId,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contacts');
        }

        return $this->render('contacts/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"DELETE"})
     * @param Request $request
     * @param Contact $contact
     * @return Response
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contacts');
    }
}
