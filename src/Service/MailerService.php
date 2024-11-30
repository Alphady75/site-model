<?php

namespace App\Service;

use App\Entity\DossierJuridique;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService
{

	private string $contactemail;
	private string $appName;

	public function __construct(private MailerInterface $mailer, private ParameterBagInterface $params)
	{
		$this->contactemail = $_ENV['CONTACT_EMAIL'];
		$this->appName = $_ENV['SITE_NAME'];
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

	public function sendContact($nom, $useremail, $sujet, $message)
	{

		$email = (new TemplatedEmail())
			->from(new Address($this->contactemail, $this->appName))
			->to($this->contactemail)
			->subject("Message de contact depuis " . $this->appName)
			->htmlTemplate('mails/_contact.html.twig')
			->context([
				'nom' => $nom,
				'useremail' => $useremail,
				'sujet' => $sujet,
				'message' => $message,
			]);

		return $this->mailer->send($email);
	}

	public function sendAideMessage(
		string $objet,
		User $user,
		$sujet,
		$demarche,
		$message,
		string $compte = null
	) {
		$template = 'mails/_aide.html.twig';
		if ($compte == 'admin') {
			$template = 'mails/_aide_admin.html.twig';
		}

		$email = (new TemplatedEmail())
			->from(new Address($this->contactemail, $this->appName))
			->to($this->contactemail)
			->subject($objet . $this->appName)
			->htmlTemplate($template)
			->context([
				'user' => $user,
				'sujet' => $sujet,
				'demarche' => $demarche,
				'message' => $message,
			]);

		return $this->mailer->send($email);
	}

	public function sendStatutMessage(DossierJuridique $dossierJuridique)
	{

		$email = (new TemplatedEmail())
			->from(new Address($this->contactemail, $this->appName))
			->to($this->contactemail)
			->subject("Mise à jour de votre dossier juridique ")
			->htmlTemplate('mails/_statut.html.twig')
			->context([
				'user' => $dossierJuridique->getDemande()->getUser(),
				'dossier' => $dossierJuridique,
			]);

		return $this->mailer->send($email);
	}

	public function sendFileByEmail(string $email, string $filePath, string $fileName): void
	{
		if (!$filePath)
			throw new \Exception('File not found');

		$absolutePath = $this->params->get('kernel.project_dir') . '/public/' . $filePath;

		if (!$filePath && !file_exists($absolutePath))
			throw new \Exception('File not found');

		$email = (new TemplatedEmail())
			->from(new Address($this->contactemail, "Nouveau message depuis votre site web"))
			->to($email)
			->subject('Voici votre ' . $fileName)
			->htmlTemplate("mails/_send_file.html.twig")
			->context([
				'usermail' => $email,
			])
			->attachFromPath($absolutePath);
		$this->mailer->send($email);
	}
}
