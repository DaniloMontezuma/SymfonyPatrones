<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData(); // Obtener los datos del formulario

            $email = (new Email())
                ->from('pruebasymfonydan@gmail.com')
                ->to('pruebasymfonydan@gmail.com')
                ->subject('Contact')
                ->html('<p>Name: ' . htmlspecialchars($data['name']) . '</p>' .
                       '<p>Email: ' . htmlspecialchars($data['email']) . '</p>' .
                       '<p>Message: ' . nl2br(htmlspecialchars($data['message'])) . '</p>');

            $mailer->send($email);

            // Aquí podrías redirigir o mostrar un mensaje de éxito
            return $this->redirectToRoute('app_contact'); // Redirigir o mostrar un mensaje de éxito
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView(),
        ]);
    }
}
