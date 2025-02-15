<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post', methods: ['GET', 'POST'])]
    public function index(PostRepository $postRepository, Request $request, MailerInterface $mailer): Response
    {
        // 🔹 Récupération des filtres de recherche
        $filters = [
            'marque' => $request->query->get('marque'),
            'modele' => $request->query->get('modele'),
            'energie' => $request->query->get('energie'),
            'prix_min' => $request->query->get('prix_min'),
            'prix_max' => $request->query->get('prix_max'),
            'kilometres_min' => $request->query->get('kilometres_min'),
            'kilometres_max' => $request->query->get('kilometres_max'),
            'puissance' => $request->query->get('puissance'),
        ];

        // 🔹 Récupération des valeurs uniques pour les filtres
        $marques = $postRepository->findDistinctValues('marque');
        $modeles = $postRepository->findDistinctValues('modele');
        $energies = $postRepository->findDistinctValues('energie');

        // 🔹 Gestion de la pagination
        $page = max(1, $request->query->getInt('page', 1)); 
        $limit = 6;

        $paginator = $postRepository->findFilteredPaginatedPosts($filters, $page, $limit);
        $totalPosts = count($paginator);

        // 🔹 Gestion du formulaire de contact
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailContent = sprintf(
                '<p><strong>Nom:</strong> %s</p>
                <p><strong>Prénom:</strong> %s</p>
                <p><strong>Email:</strong> %s</p>
                <p><strong>Message:</strong> %s</p>',
                htmlspecialchars($contact->getFirstname()),
                htmlspecialchars($contact->getLastname()),
                htmlspecialchars($contact->getEmail()),
                nl2br(htmlspecialchars($contact->getMessage()))
            );

            $email = (new Email())
                ->from($contact->getEmail())
                ->to('gwadacardiscount.contact@gmail.com')
                ->subject('Nouveau message depuis le formulaire de contact')
                ->html($emailContent);

            try {
                $mailer->send($email);
                $this->addFlash('success', 'Votre message a été envoyé avec succès.');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erreur lors de l\'envoi du message : ' . $e->getMessage());
            }

            return $this->redirectToRoute('app_post');
        }

        // 🔹 Rendu de la page avec les données
        return $this->render('post/index.html.twig', [
            'formContact' => $form->createView(),
            'annonces' => $paginator,
            'marques' => $marques,
            'modeles' => $modeles,
            'energies' => $energies,
            'slug' => 'gwadacardiscount',
            'currentPage' => $page,
            'totalPages' => ceil($totalPosts / $limit),
        ]);
    }
}
