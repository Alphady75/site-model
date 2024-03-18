<?php

namespace App\Service;

use App\Entity\Invitation;
use App\Entity\Register;
use App\Entity\Registration;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService
{

	private string $contactemail;

	public function __construct(private MailerInterface $mailer)
	{
		$this->contactemail = $_ENV['CONTACT_EMAIL'];
	}

	public function sendDevisNotification(string $user, string $email, string $sujet, string $message)
	{

		$email = (new TemplatedEmail())
			->from(new Address($this->contactemail, "Nouveau message depuis votre site web"))
			->to($this->contactemail)
			->subject($sujet)
			->htmlTemplate("mails/_devis.html.twig")
			->context([
				'user' => $user,
				'usermail' => $email,
				'sujet' => $sujet,
				'message' => $message,
			]);

		return $this->mailer->send($email);
	}
}
