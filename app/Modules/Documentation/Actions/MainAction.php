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

    // Home

    public function home(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/home.twig');
    }

    // Form

    public function dateTimePicker(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/datetimepicker.twig');
    }

    public function ajax_form(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/ajax_form.twig');
    }

    public function ajax_formTest(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();
        $method     = $request->getMethod();

        $validator =  $this->{'@Documentation\Validation'}->validator("formTest", $method, $parsedBody);

        if (is_array($validator)) {
            return $response->withJson(array(
                'messages' => $validator
            ), 400);
        }

        if ($parsedBody['select1'] == 'ok') {
            return $response->withJson([
                "message" => 'Sikeres művelet lett kiválasztva!'
            ], 200);
        }
        else {
            sleep(1);
            return $response->withJson([
                "message" => 'Sikertelen művelet lett kiválasztva!'
            ], 400);
        }
    }

    // Alert

    public function alert(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/alert.twig');
    }

    // URL

    public function ajax_url(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/ajax_url.twig');
    }

    public function ajax_urlTestOK(Request $request, Response $response, $args)
    {
        return $response->write('Sikeres válasz, de ez nem JSON!', 200);
    }

    public function ajax_urlTestFail(Request $request, Response $response, $args)
    {
        sleep(3);
        return $response->withJson([
            "message" => 'Sikertelen kérés!'
        ], 400);
    }

    // MODAL

    public function ajax_modal(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/ajax_modal.twig');
    }

    public function ajax_modalTest(Request $request, Response $response, $args)
    {
        sleep(1);

        $data = array(
            'kutya', 'macska', 'borz'
        );

        return $this->view->render($response, '@Documentation/modal/ajax_modal_test.twig', ['data' => $data]); 
    }

    public function ajax_modalTestJSON(Request $request, Response $response, $args)
    {
        $data = array(
            'kutya', 'macska', 'borz'
        );

        return $response->withJson([
            'modal-title'  => $this->view->fetchBlock('@Documentation/modal/ajax_modal_test_json.twig', 'title'),
            'modal-body'   => $this->view->fetchBlock('@Documentation/modal/ajax_modal_test_json.twig', 'body', ['data' => $data]),
            'modal-footer' => $this->view->fetchBlock('@Documentation/modal/ajax_modal_test_json.twig', 'footer')
        ], 200);
    }

    // BLURBOX

    public function bb(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/bb.twig');
    }

    public function bbTest(Request $request, Response $response, $args)
    {
        sleep(1);

        $data = array(
            'kutya', 'macska', 'borz'
        );

        return $this->view->render($response, '@Documentation/modal/ajax_bb_test.twig', ['data' => $data]); 
    }

    // DATATABLE

    public function datatable(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/datatable.twig');
    }

    public function cssJs(Request $request, Response $response, $args)
    {
        return $this->view->render($response, '@Documentation/css_js.twig');
    }


    public function datatableJSONResponse(Request $request, Response $response, $args)
    {
        sleep(20);

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

}
