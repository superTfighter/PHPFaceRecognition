<?php

namespace App\Modules\System\Handler;

use App\Traits\CoreTrait;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Az alap: https://akrabat.com/logging-errors-in-slim-3/
//   - backtrace kiiras lehetne szebb
//     (http://php.net/manual/en/exception.gettraceasstring.php)
//   - nem supportol $exception->getPrevious wrapped exceptionoket
class Error extends \Slim\Handlers\Error
{
    use CoreTrait;

    public function __invoke(Request $request, Response $response, \Exception $exception)
    {
        $msg = $this->formatException($exception);

        $this->logger->critical($msg);
        $this->sendEmails($msg);

        return parent::__invoke($request, $response, $exception);
    }

    private function formatException( $exception )
    {
        if ($exception instanceof \ErrorException)
        {
            $errno = $this->severityToString( $exception->getSeverity() );
            if (($code = $exception->getCode()))
                $errno .= '|' . $code;
        } else
            $errno = $exception->getCode();

        $errstr    = str_replace( array("\r\n", "\n", "\r"), '', $exception->getMessage() );
        $errfile   = $exception->getFile();
        $errline   = $exception->getLine();
        $backtrace = $exception->getTraceAsString();
        $class     = 'CAUGHT ' . get_class( $exception ) . ' EXCEPTION';

        // idegesitoen hosszu path-ek amik mindig ugyanazok, azokat roviditsuk
        $basedir = realpath(__DIR__ . "/../..") . DIRECTORY_SEPARATOR;

        $error =
          "$class (#$errno)\n" .
          "$errstr\n" .
          "in file $errfile:$errline\n\n" .
          $backtrace
        ;
        $error = str_replace( $basedir, '', $error ); // path rovidites
        $error = trim( $error ) . "\n\n";
        $error .=
            "REQUEST_URI: " . @$_SERVER['REQUEST_URI'] . "\n" .
            "SERVER_NAME: " . @$_SERVER['SERVER_NAME'] . "\n" .
            "REFERER:     " . @$_SERVER['HTTP_REFERER'] . "\n" .
            "REMOTE_ADDR: " . @$_SERVER['REMOTE_ADDR'] . "\n" .
            "REMOTE_HOST: " . @$_SERVER['REMOTE_HOST'] . "\n" .
            "HTTP_HOST:   " . @$_SERVER['HTTP_HOST'] . "\n" .
            "\n"
        ;

        foreach(['_GET', '_POST', '_FILES', '_COOKIE', '_SESSION'] as $field )
        {
            if ( !isset( $GLOBALS[ $field ] ) or empty( $GLOBALS[ $field ] ) )
                continue;

            $error .= ltrim( $field, '_' ) . ": ------------------------------\n";
            $error .= $this->getSuperglobal( $GLOBALS[ $field ] ) . "\n";
        }

        // minden kezdodjon beljebb 2 spacel
        $error = preg_replace('/^/m', '  ', $error);

        // kiveve az elso sort
        return ltrim( $error );
    }

    private function getSuperglobal( $value )
    {
        if (empty($value)) {
            return "empty";
        }

        if (!ob_start()) {
            throw new \Exception('Could not start output buffer!');
        }

        var_dump($value);

        $ret = ob_get_contents();
        ob_end_clean();

        return $ret;
    }

    private function severityToString( $severity )
    {
        switch ( $severity ) {
            case E_USER_ERROR:        $ret = 'E_USER_ERROR';        break;
            case E_USER_WARNING:      $ret = 'E_USER_WARNING';      break;
            case E_USER_NOTICE:       $ret = 'E_USER_NOTICE';       break;
            case E_USER_DEPRECATED:   $ret = 'E_USER_DEPRECATED';   break;
            case E_PARSE:             $ret = 'E_PARSE';             break;
            case E_NOTICE:            $ret = 'E_NOTICE';            break;
            case E_ERROR:             $ret = 'E_ERROR';             break;
            case E_WARNING:           $ret = 'E_WARNING';           break;
            case E_RECOVERABLE_ERROR: $ret = 'E_RECOVERABLE_ERROR'; break;
            case E_DEPRECATED:        $ret = 'E_DEPRECATED';        break;
            case E_STRICT:            $ret = 'E_STRICT';            break;
            default:                  $ret = "E_UNKNOWN-$severity"; break;
        }

        return $ret;
    }

    private function sendEmails($msg)
    {
        $settings = $this->settings['settings']['System']['Mail'];

        if ( empty( $settings['logEmails'] ) )
            return;

        // veletlen se kuldjunk masnak emailt
        $this->mail->clearAllRecipients();
        $this->mail->isHTML(false);

        foreach($settings['logEmails'] as $email) {
            $this->mail->addBCC($email);
        }

        $pos = strpos($this->mail->From, '@');

        if ($pos !== false) {
            $domain = substr($this->mail->From, $pos + 1);
        } else {
            $domain = 'niif.hu';
        }

        // elso es harmadik sor definialja a pontos hibat,
        // ebbol csinalunk messageid-t hogy konnyu legyen torolni a leveleket
        // es ugyanazok a hibak ugyanabban a threadben legyenek
        $c = strtok(ltrim($msg), "\n");
        strtok("\n"); // masodik sor ignore
        $c .= strtok("\n");
        $this->mail->MessageID = '<' . sha1($c) . '@' . $domain . '>';

        // TODO ertelmesebb subjectet
        $this->mail->Subject = mb_substr(
            trim(
                preg_replace(
                    "/[\r\n ]+/",
                    " ",
                    ltrim( $msg )
                )
            ),
            0,
            78
        );

        $this->mail->Body = $msg;

        $this->mail->send();
    }
}
