<?php

namespace App\Modules\Documentation\Actions;

use App\Traits\CoreTrait;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ExceptionInterface;
use Respect\Validation\Exceptions\ValidationException;

use Slim\Http\Request;
use Slim\Http\Response;

class MainAction
{
	use CoreTrait;

    // URL

    public function url(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/url.twig');
    }

    public function urlTest1OK(Request $request, Response $response, $args)
    {
        return $response->write('Sikeres válasz, de ez nem JSON!', 200);
    }

    public function urlTest1Fail(Request $request, Response $response, $args)
    {
        sleep(3);
        return $response->withJson([
            "message" => 'Sikertelen kérés!'
        ], 400);
    }

    // MODAL

    public function modal(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/modal.twig');
    }

    public function datatable(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/datatable.twig');
    }

    public function cssJs(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/css_js.twig');
    }

    public function modalJSONResponse(Request $request, Response $response, $args)
    {
        return $response->withJson([
            'modal-title'  => 'This title came from a <b>JSON response</b>',
            'modal-body'   => '<button class="btn btn-primary">HTML content\'s allowed</button>',
            'modal-footer' => '<a class="close btn btn-default">Mégse</a>',
        ], 200);
    }

    public function datatableJSONResponse(Request $request, Response $response, $args)
    {
        return $response->withJson([
            "recordsTotal"    => 123,
            "recordsFiltered" => 123,
            "data"            => [
                [
                    "id"               => 1426,
                    "type"             => "RELEASE",
                    "ticket_id"        => "999999999",
                    "start"            => "2020-04-21 08:34",
                    "end"              => "2020-04-23 08:34",
                    "location"         => "Debrecen",
                    "source"           => "Kábel EDITED",
                    "device"           => "Optikai Kábel EDITED",
                    "description"      => "Eseménynapló",
                    "recorded_by"      => "153targyalo@kifu.gov.hu",
                    "fixed"            => "Végrehajtó",
                    "deleted"          => null,
                    "updated"          => "2020-03-06 08:49:04",
                    "updated_by"       => "lszabolcs@niif.hu",
                    "added"            => "2020-03-06 08:36:38",
                    "added_by"         => "lszabolcs@niif.hu",
                    "hasCMS"           => 1,
                    "recorded_by_name" => "222-es tárgyaló (Csalogány)",
                    "editable"         => true
                ],
                [
                    "id"               => 1429,
                    "type"             => "CHANGE",
                    "ticket_id"        => "abc",
                    "start"            => "2020-03-25 11:45",
                    "end"              => "2020-03-25 11:45",
                    "location"         => "",
                    "source"           => "",
                    "device"           => "",
                    "description"      => "",
                    "recorded_by"      => null,
                    "fixed"            => "",
                    "deleted"          => null,
                    "updated"          => "2020-03-25 11:46:10",
                    "updated_by"       => "",
                    "added"            => "2020-03-25 11:46:10",
                    "added_by"         => "lszabolcs@niif.hu",
                    "hasCMS"           => 1,
                    "recorded_by_name" => "-",
                    "editable"         => true
                ]
            ]
        ], 200);
    }

    public function modalTest1(Request $request, Response $response, $args)
    {
        $data = $this->api->iir->call('/cim', ['query' => ['limit' => 5]]);

        return $this->view->render($response, '@Documentation/modal/modal_test1.twig', ['data' => $data]);   
    }

    public function modalTest2(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/modal/modal_test2.twig');   
    }

    // Submit hook
    public function formTest1(Request $request, Response $response, $args)
    {

        // start Validator block
        $body   = $request->getParsedBody();
        $method = $request->getMethod();

        // Custom module validation rules
        $validator =  $this->{'@Documentation\Validation'}->validator("test", $method, $body);
        // end Validator block


        return $response->withJson(array(
            'info'    => 'Invalid parameter',
            'status'  => 'ERROR',
            't' => $validator,
            'validation_messages' => array(
                'Nincs jogosultsága a művelethez!'
            ),
            'code' => 400
        ), 400);
    }
}
