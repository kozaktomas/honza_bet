<?php

namespace Bet;


use Bet\Http\CnbScraper;
use Bet\Mail\Mailer;

class PoorEuropeanAssholesBet
{

	const CURRENCY = 'EUR';

	const EXCHANGE_RATE_LIMIT = 26;

	const TARGETED_YEAR = 2017;

	/** @var CnbScraper */
	private $cnbScraper;

	/** @var Mailer */
	private $mailer;

	/**
	 * PoorEuropeanAssholesBet constructor.
	 * @param CnbScraper $cnbScraper
	 * @param Mailer $mailer
	 */
	public function __construct(CnbScraper $cnbScraper, Mailer $mailer)
	{
		$this->cnbScraper = $cnbScraper;
		$this->mailer = $mailer;
	}

	public function resolve()
	{
		try {
			$exchangeRate = $this->cnbScraper->getExchangeRate(self::CURRENCY);

			$today = new \DateTime();
			$currentYear = (int)$today->format('Y');

			if ($currentYear === self::TARGETED_YEAR) {
				if ($exchangeRate < self::EXCHANGE_RATE_LIMIT) {
					$this->mailer->sendEmail(Mailer::EMAIL_TOMAS, Mailer::DEFAULT_SUBJECT, 'Prohral jsi. Kup rum');
					$this->mailer->sendEmail(Mailer::EMAIL_HONZA, Mailer::DEFAULT_SUBJECT, 'Vyhral jsi. Ocekavej rum');
				}
			} else {
				$this->mailer->sendEmail(Mailer::EMAIL_TOMAS, Mailer::DEFAULT_SUBJECT, 'Vyhral jsi. Ocekavej rum');
				$this->mailer->sendEmail(Mailer::EMAIL_HONZA, Mailer::DEFAULT_SUBJECT, 'Prohral jsi. Kup rum');
			}
		} catch (\Exception $e) {
			echo 'Program failed with error: ' . $e->getMessage();
		}
	}
}