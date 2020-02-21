<?php

namespace App\Modules\Ekreta\Actions;

use App\Traits\CoreTrait;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Exceptions\ValidationException;

use Slim\Http\Request;
use Slim\Http\Response;
use ALFI\Api\GeneralApi;
use ALFI\Config;

class EkretaAction
{
    use CoreTrait;


    public function login($request, $response, $args)
    {
        // Need a list of schools with institute code
        return $this->view->render($response, '@Ekreta/login.twig');
    }

    public function loginPost($request, $response, $args)
    {
        $form_data = $request->getParsedBody();

        if ($this->{'@Ekreta\EkretaRepository'}->login($form_data)) {

            // Sikeres bejelentkezés esetén

            print_r("Sikeres bejelentkezés!");

            return $response->withRedirect($this->router->pathFor('userData'));
        } else {

            print_r("Sikertelen bejelentkezés!");
        }
    }

    public function userData($request, $response, $args)
    {
        $userData = $this->{'@Ekreta\EkretaRepository'}->getUserData();
        return $this->view->render($response, '@Ekreta/userData.twig', ['user' => $userData]);
    }

    public function register($request, $response, $args)
    {
        $userData = $this->{'@Ekreta\EkretaRepository'}->getUserData();
        var_dump($userData);
        $nameSplit = explode(' ', $userData['nev']);
        $generatedName = substr($nameSplit[0], 0, 3) . substr($nameSplit[1], 0, 3);
       
        return $this->view->render($response, '@Ekreta/register.twig', ['name' => $generatedName]);
    }

    public function registerPost($request, $response, $args)
    {
        $data = $request->getParsedBody();

        $this->{'@IIR\LdapFactory'}->createUserInLdap($data);

        //TODO:
    }

    // Implicit flow implementation
    public function implicit($request, $response, $args)
    {
        $idpUrl = $this->container->get('settings')['settings']['System']['Api']['kretaIdp']['options']['APIurl'];

        $redirectUri = urlencode('https://dev.alfi.niif.hu' . $this->router->pathFor('implicitGet'));

        //$idpUrl = $idpUrl . '/connect/authorize?client_id=kifu-eduroam&redirect_uri=' . $redirectUri . '&response_type=id_token token&scope=kreta-core-webapi.public openid&nonce=jal1ZnCzahth8r9D5Dua0wTQGqdN1QRNC7x6yu7g';

        $idpUrl = $idpUrl . '/connect/authorize?' . 'response_type=id_token ' . 'token&client_id=kifu-eduroam' . '&redirect_uri=' . $redirectUri . '&response_type=id_token ' . 'token&scope=kreta-core-webapi.public ' . 'openid&nonce=jal1ZnCzahth8r9D5Dua0wTQGqdN1QRNC7x6yu7g';
        //print($idpUrl);die();
        return $response->withRedirect($idpUrl);
    }

    // Token get by js
    public function implicitGet($request, $response, $args)
    {
        return $this->view->render($response, '@Ekreta/redirect.twig');
    }

    public function tokenCheck($request, $response, $args)
    {
        $this->{'@Ekreta\EkretaRepository'}->setToken($args['token']);

        return $response->withRedirect($this->router->pathFor('userData'));
    }

    public function applications($request, $response, $args)
    {
    }
}
