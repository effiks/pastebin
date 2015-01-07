<?php
App::uses('AppController', 'Controller');


class PastesController extends AppController {
    public function beforeFilter() {
        $this->Crud->mapAction('index', 'Crud.Index');
        $this->Crud->mapAction('view', 'Crud.View');
        $this->Crud->mapAction('add', 'Crud.Add');
        $this->Crud->mapAction('edit', 'Crud.Edit');
        $this->Crud->mapAction('delete', 'Crud.Delete');

        $this->Crud->mapAction('p', 'Crud.View');
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

        return $this->Crud->execute();
    }

    public function view($id) {
        // Modifies the find conditions for our privacy settings
        $this->Crud->on('beforeFind', function(CakeEvent $event) {
            // Ensures that privacy is off for a given paste
            $event->subject->query['conditions'] = [
                'Paste.id' => $event->subject->id,
                'Paste.private' => false,
            ];
        });

        return $this->Crud->execute();
    }

    public function add() {
        $this->Crud->on('beforeRedirect', [$this, '_onBeforeRedirectSave']);
        return $this->Crud->execute();
    }

    public function edit() {
        $this->Crud->on('beforeRedirect', [$this, '_onBeforeRedirectSave']);
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
}
?>