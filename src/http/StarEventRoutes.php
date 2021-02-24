<?php


namespace app\http;


use app\models\star_event\Form;
use app\models\MailMessage;
use app\models\town\TownsRepository;
use app\services\MailTransport;
use app\services\WeatherProviderService;
use Exception;


/**
 * Class StarEventRoutes
 * @package app
 */
class StarEventRoutes extends HttpRouteHandler
{
    /** @var Form */
    protected Form $eventForm;

    /** @var TownsRepository */
    private TownsRepository $townsRepository;

    /** @var WeatherProviderService */
    private WeatherProviderService $weatherProvider;

    /** @var MailTransport */
    private MailTransport $transportService;

    /**
     * StarEventRoutes constructor.
     */
    public function __construct()
    {
        $this->eventForm = new Form();
        $this->townsRepository = new TownsRepository();
        $this->weatherProvider = new WeatherProviderService();
        $this->transportService = new MailTransport();
    }

    /**
     *
     */
    public function show()
    {
        try {
            $townsList = $this->townsRepository->getAll();
            $this->renderHTML('form', [
                Form::$NAME => '',
                Form::$EMAIL => '',
                Form::$TOWN => '',
                Form::$EVENT_SESSION => '',
                Form::$COMMENT => '',
                'townsList' => $townsList,
                'csrf' => $this->generateCSRFToken(true)
            ]);
        } catch (Exception $e) {
            // non exists Logger::error($e);
            $this->renderHTML('error', ['message' => $e->getMessage()]);
        }
    }

    /**
     *
     */
    public function submittedFormHandler()
    {
        $this->eventForm->handleRequest($_POST);

        if (!$this->isValidCSRF()) {
            $this->renderJSON(['error' => 'Not valid CSRF Token']);
            return;
        }

        if (!$this->eventForm->hasErrors() && boolval($_POST['submit'])) {
            $mail = new MailMessage(
                $_POST['name'],
                $_POST['email'],
                $this->townsRepository->getById($_POST['town']),
                (new \DateTime())->setTimestamp($_POST['event-session'])
            );
            $this->transportService->send($mail);
            $this->renderJSON(['status' => 'done']);
        } else {
            $this->renderJSON($this->eventForm->getErrors());
        }
    }

    /**
     *
     */
    public function eventSessionsHandler()
    {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON);

        if (!is_a($input, 'stdClass') || $input->selectedTown < 0) {
            $this->renderJSON(['error' => 'Town not selected']);
        }

        try {
            $town = $this->townsRepository->getById($input->selectedTown);
            $this->weatherProvider->fetch($town->getTown());
            $town->setWeatherForEventSession($this->weatherProvider->getResponse());
            $this->renderJSON($town->getEventSessions());
        } catch (Exception $exception) {
            // non exists Logger::error($e);
            $this->renderHTML('error', ['message' => $exception->getMessage()]);
        }
    }

    public function donePageHandler()
    {
        $this->renderHTML('done', [
            'message' => 'Are done check your mail inbox',
        ]);
    }

}