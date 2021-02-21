<?php


namespace app\http;


use app\models\EventForm;
use app\models\MailMessage;
use app\models\TownsRepository;
use app\services\MailTransportService;
use app\services\WeatherProviderService;
use Exception;
use PDO;


/**
 * Class EventFormController
 * @package app
 */
class EventFormController extends Controller
{
    /** @var EventForm */
    protected EventForm $eventForm;

    /** @var TownsRepository */
    private TownsRepository $townsRepository;

    /** @var WeatherProviderService */
    private WeatherProviderService $weatherProvider;

    /** @var MailTransportService */
    private MailTransportService $transportService;

    /**
     * EventFormController constructor.
     */
    public function __construct()
    {
        $this->eventForm = new EventForm();
        $this->townsRepository = new TownsRepository();
        $this->weatherProvider = new WeatherProviderService();
        $this->transportService = new MailTransportService();
    }

    /**
     *
     */
    public function show()
    {
        try {
            $townsList = $this->townsRepository->getAll();
            //var_dump($townsList);
            $this->render('form', [
                EventForm::$NAME => '',
                EventForm::$EMAIL => '',
                EventForm::$TOWN => '',
                EventForm::$EVENT_SESSION => '',
                EventForm::$COMMENT => '',
                'townsList' => $townsList,
                'csrf' => $this->generateCSRFToken(true)
            ]);
        } catch (Exception $e) {
            // non exists Logger::error($e);
            $this->render('error', ['message' => $e->getMessage()]);
        }
    }

    /**
     *
     */
    public function submittedFormHandler()
    {
        $this->eventForm->handleRequest($_POST);

        if (!$this->validCSRF()) {
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
            $this->render('error', ['message' => $exception->getMessage()]);
        }
    }

    public function donePageHandler()
    {
        $this->render('done', [
            'message' => 'Are done check your email inbox',
        ]);
    }

}
