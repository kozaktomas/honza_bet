<?php

namespace Bet\Mail;


class Mailer
{

	const EMAIL_TOMAS = 'tomas@socialwifi.cz';

	const EMAIL_HONZA = 'honza@socialwifi.cz';

	const DEFAULT_SUBJECT = 'Sazka EUR';

	/**
	 * @param string $to
	 * @param string $subject
	 * @param string $text
	 * @throws \Exception
	 */
	public function sendEmail($to, $subject, $text)
	{
		if (!mail($to, $subject, $text)) {
			throw new \Exception("Can't send email via mail() function");
		}
	}

}