<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use App\Decorator\HeaderDecorator;
use App\Decorator\EmailFooterDecorator; // Actualiza aquí

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = '<p>Name: ' . htmlspecialchars($data['name']) . '</p>' .
                       '<p>Email: ' . htmlspecialchars($data['email']) . '</p>' .
                       '<p>Additional Emails: ' . htmlspecialchars($data['additionalEmails']) . '</p>' .
                       '<p>Message: ' . nl2br(htmlspecialchars($data['message'])) . '</p>';

            // Aplicar los decoradores
            $header = new HeaderDecorator($message);
            $footer = new EmailFooterDecorator($header->getContent()); // Actualiza aquí

            $email = (new Email())
                ->from('pruebasymfonydan@gmail.com')
                ->to('pruebasymfonydan@gmail.com')
                ->subject('Contact')
                ->html($footer->getContent());

            // Agregar direcciones de correo adicionales
            $additionalEmails = array_filter(array_map('trim', explode(',', $data['additionalEmails'])));
            foreach ($additionalEmails as $additionalEmail) {
                if (preg_match('/@gmail\.com$/', $additionalEmail)) {
                    $email->addTo($additionalEmail);
                }
            }

            // Manejar el archivo adjunto
            if ($data['attachment']) {
                $attachment = DataPart::fromPath($data['attachment']->getPathname());
                $email->attach($attachment);
            }

            $mailer->send($email);

            return $this->redirectToRoute('app_contact'); 
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView(),
        ]);
    }
}
