<?php
App::uses('AppController', 'Controller');
App::uses('DebugTimer', 'DebugKit.Lib');

class PastesController extends AppController {
    public function beforeFilter() {
        $this->Crud->mapAction('index', 'Crud.Index');
        $this->Crud->mapAction('view', 'Crud.View');
        $this->Crud->mapAction('add', 'Crud.Add');
        $this->Crud->mapAction('edit', 'Crud.Edit');
        $this->Crud->mapAction('delete', 'Crud.Delete');

        $this->Crud->mapAction('p', 'Crud.View');

        parent::beforeFilter();

        // Allow all users access to index, view and p action
        $this->Auth->allow('index', 'view', 'p');

        // Also allow anonymous paste creation
        $this->Auth->allow('add');
    }

    public function index() {
        $this->Crud->on('beforePaginate', function(CakeEvent $event) {
            $event->subject->paginator->settings['conditions']['private'] = false;
        });
        return $this->Crud->execute();
    }

    public function p($id) {
        // Allows the $id to contain non-numeric values
        $this->Crud->action()->config('validateId', false);

        // Share the 'view' template with this action
        $this->Crud->action()->config('view', 'view');

        // Modifies the find condition for our privacy settings
        $this->Crud->on('beforeFind', function(CakeEvent $event) {
            // Configures a new tiny instance based on our configure call
            $tiny = new \ZackKitzmiller\Tiny(Configure::read('Tiny.set'));

            // Ensures that the find conditions reverse the tiny hash
            // and that the find only affects private pastes
            $event->subject->query['conditions'] = [
                'Paste.id' => $tiny->from($event->subject->id),
                'Paste.private' => true,
            ];
        });

        $this->set('noIndex', true);
        return $this->Crud->execute();
    }

    public function view($id) {
        DebugTimer::start('PastesController::attach_beforefind_event');
        // Modifies the find conditions for our privacy settings
        $this->Crud->on('beforeFind', function(CakeEvent $event) {
            // Ensures that privacy is off for a given paste
            $event->subject->query['conditions'] = [
                'Paste.id' => $event->subject->id,
                'Paste.private' => false,
            ];
        });
        DebugTimer::stop('PastesController::attach_beforefind_event');

        DebugTimer::start('Crud::execute');
        return $this->Crud->execute();
        DebugTimer::stop('Crud::execute');
    }

    public function add() {
        $this->Crud->on('beforeRedirect', [$this, '_onBeforeRedirectSave']);

        // Get the current user_id
        $user_id = $this->Auth->user('id');

        // Hook into the initialize Crud event and pass in the user_id
        $this->Crud->on('initialize', function(CakeEvent $event) use ($user_id) {
            // Get a shorter reference to the request object
            $request = $event->subject->request;

            // Only modify the data if it is a POST or PUT request
            if ($request->is(['post', 'put'])) {
                // Set the user_id in the posted data
                $request->data['Paste']['user_id'] = $user_id;
            }
        });

        return $this->Crud->execute();
    }

    public function edit() {
        $this->Crud->on('beforeRedirect', [$this, '_onBeforeRedirectSave']);
        $this->Crud->on('beforeFind', [$this, '_onBeforeFind']);
        return $this->Crud->execute();
    }

    public function delete() {
        $this->Crud->on('beforeFind', [$this, '_onBeforeFind']);
        return $this->Crud->execute();
    }

    public function _onBeforeRedirectSave(CakeEvent $event) {
        // Short-circuit if the paste is not private
        $data = $event->subject->request->data;
        if (!Hash::get($data, 'Paste.private')) {
            return;
        }

        // Construct the private url using the Tiny class
        $tiny = new \ZackKitzmiller\Tiny(Configure::read('Tiny.set'));
        $pasteUrl = Router::url([
            'controller' => 'pastes',
            'action' => 'p',
            $tiny->to($event->subject->id)
        ], true);

        // Modify the message to include the private paste url
        $Session = $event->subject->controller->Session;
        $message = $Session->read('Message.flash');
        $Session->delete('Message.flash');
        $Session->setFlash(
            $message['message'] . ' at url ' . $pasteUrl,
            $message['element'],
            $message['params'],
            'flash'
        );
    }

    public function _onBeforeFind(CakeEvent $event) {
        $user_id = $this->Auth->user('id');

        // do not give non-logged in users edit/deletion abilities
        if (empty($user_id)) {
            $event->stopPropagation();
        }

        // Scope the find to the current user
        $event->subject->query['conditions']['Paste.user_id'] = $user_id;
    }
}
?>