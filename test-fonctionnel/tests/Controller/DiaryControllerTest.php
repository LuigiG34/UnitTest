<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DiaryControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;
    private $userRepository = null;
    private $user = null;
    private $urlGenerator = null;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);

        // Mettre comme argument de la méthode FindOneByEmail

        // l'e-mail utilisé sur GitHub, ou regarder en base de données quel est l'e-mail renseigné.

        $this->user = $this->userRepository->findOneByEmail('luigigandemer6@gmail.com');

        $this->urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->loginUser($this->user);
    }

    public function testHomepageIsUp()
    {
        $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('homepage'));

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHomepage()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('homepage'));

        $this->assertSame(1, $crawler->filter('h1')->count());
    }

    public function testAddRecord()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('add-new-record'));

        $form = $crawler->selectButton('Enregistrer')->form();
        $form['food[entitled]'] = 'Plat de pâtes';
        $form['food[calories]'] = 600;

        $this->client->submit($form);
        $this->client->followRedirect();
        // echo $this->client->getResponse()->getContent();
        // echo $this->client->getProfile();

        $this->assertSelectorTextContains('div.alert.alert-success', 'Ajouter une nouvelle entrée.');
    }

    public function testList()
    {
        $crawler = $this->client->request(Request::METHOD_GET, $this->urlGenerator->generate('diary'));
        $link = $crawler->selectLink('Voir tous les rapports')->link();
        $crawler = $this->client->click($link);
        $info = $crawler->filter('h1')->text();
        // On retire les retours à la ligne pour faciliter la vérification
        $info = $string = trim(preg_replace('/\s\s+/', ' ', $info));
        $this->assertSame("Tous les rapports Tout ce qui a été mangé !", $info);
    }
}
