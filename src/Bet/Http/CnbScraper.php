<?php

namespace Bet\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CnbScraper
{

	/**
	 * @param string $currency
	 * @return float
	 * @throws \Exception
	 */
	public function getExchangeRate($currency)
	{
		try {
			$client = new Client();
			$res = $client->request(
				'GET',
				'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt'
			);
		} catch (RequestException $exception) {
			throw new \Exception("Can't download current exchange rate: " . $exception->getMessage());
		}

		return $this->parseResponse($res->getBody(), $currency);
	}

	/**
	 * @param string $resp
	 * @param string $currency
	 * @return float
	 * @throws \Exception
	 */
	private function parseResponse($resp, $currency) {
		$rows = explode("\n", $resp);
		foreach ($rows as $row) {
			$row = trim($row);
			$values = explode("|", $row);
			if (count($values) === 5 && strtoupper($values['3']) === $currency) {
				return (float)str_replace(',', '.', $values['4']);
			}
		}

		throw new \Exception('Currency not found in CNB list;');
	}


}