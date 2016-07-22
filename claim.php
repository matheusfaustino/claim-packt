<?php

include 'vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;

$baseUri = 'https://www.packtpub.com';
$Uri = '/packt/offers/free-learning';

$client = new GuzzleHttp\Client(['base_uri' => $baseUri, 'cookies' => true, 'allow_redirects' => true]);
// $res = $client->request('GET', $Uri);

// $crawler = new Crawler((string)$res->getBody(true), $baseUri);

// $link = $crawler->filter('a.twelve-days-claim');

$clientGoutte = new Goutte\Client();
$clientGoutte->setClient($client);
$crawlerGoutte = $clientGoutte->request('GET', sprintf('%s%s', $baseUri, $Uri));

$form = $crawlerGoutte->selectButton('Login')->form([
	'email' => 'matheuspfaustino@gmail.com',
	'password' => '21021993m'
]);

$submitted = $clientGoutte->submit($form);

$link = $submitted->filter('a.twelve-days-claim')->attr('href');

// echo '<pre>';
// print_r($link);
// echo '</pre>';

$claimRest = $clientGoutte->request('GET', $link);
// $crawlerRest = new Crawler((string)$claimRest->getBody(true));

// echo $link->attr('href');
// echo $submitted;
echo $claimRest->html();
