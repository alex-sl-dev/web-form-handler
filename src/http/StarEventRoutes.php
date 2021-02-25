<?php


namespace app\http;


use app\models\star_event\EventSessionRepository;
use app\models\star_event\Form;
use app\models\star_event\StarEvent;
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
    /** @var TownsRepository */
    private TownsRepository $townsRepository;

    /** @var WeatherProviderService */
    private WeatherProviderService $weatherProvider;

    /** @var MailTransport */
    private MailTransport $mailTransport;

    /** @var EventSessionRepository */
    private EventSessionRepository $eventSessionRepository;

    /**
     * StarEventRoutes constructor.
     */
    public function __construct()
    {
        $this->townsRepository = new TownsRepository();
        $this->eventSessionRepository = new EventSessionRepository();
        $this->weatherProvider = new WeatherProviderService();
        $this->mailTransport = new MailTransport();
    }

    public function show()
    {
        try {
            $townsList = $this->townsRepository->getAll();

            $this->renderHTML('form', [
                Form::$NAME => '',
                Form::$EMAIL => '',
                Form::$TOWN => '',
                Form::$EVENT => '',
                Form::$COMMENT => '',
                'townsList' => $townsList,
                'csrf' => $this->generateCSRFToken(true)
            ]);
        } catch (Exception $e) {
            // non exists Logger::error($e);
            $this->renderHTML('error', ['message' => $e->getMessage()]);
        }
    }

    public function submittedFormHandler(): void
    {
        if (!$this->isValidCSRF()) {
            $this->renderJSON(['error' => 'Not valid CSRF Token']);
            return;
        }

        if (!$_POST[StarEvent::$TOWN]) {
            $this->renderJSON(['status' => 'validate']);
            return;
        }

        $town = $this->townsRepository->getById($_POST[StarEvent::$TOWN]);

        // @todo some cache
        $starEvent = new StarEvent(
            $_POST[StarEvent::$NAME],
            $_POST[StarEvent::$EMAIL],
            $town,
            $_POST[StarEvent::$COMMENT]
        );

        if (empty($starEvent->getErrors()) && boolval($_POST['submit'])) {
            $this->eventSessionRepository->save($starEvent);
            /*
            $mail = new MailMessage(
            $_POST['name'],
            $_POST['email'],
            $this->townsRepository->getById($_POST['town']),
            (new \DateTime())->setTimestamp($_POST['event-session'])
            );
            $this->transportService->send($mail);

            $this->renderJSON(['status' => 'done']);
            */
            $this->renderJSON($starEvent->getErrors());
        }
    }

    public function eventSessionsHandler()
    {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON);

        if (!is_a($input, 'stdClass') || $input->selectedTown < 0) {
            $this->renderJSON(['error' => 'Town not selected']);
        }

        try {
            $town = $this->townsRepository->getById($input->selectedTown);
            $this->renderJSON($town->getSunnyEventSessions());
        } catch (Exception $exception) {
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
