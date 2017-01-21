<?php

require __DIR__ . "/../vendor/autoload.php";

$cnbScraper = new \Bet\Http\CnbScraper();
$mailer = new \Bet\Mail\Mailer();

$bet = new \Bet\PoorEuropeanAssholesBet($cnbScraper, $mailer);
$bet->resolve();