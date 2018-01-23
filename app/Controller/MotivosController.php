<?php


class MotivosController extends AppController{
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny();
    }
	public function isAuthorized() {
        // Admin can access every action
        $admin = $this->Session->read('Auth.User.admin');
        if ($this->action === 'gerenciarmotivos') {
			return true;
		}if ($this->action === 'delete') {
			return true;
		}
	}
			
    public function gerenciarmotivos(){
        if ($this->request->is('post')) {
            if ($this->Motivo->save($this->request->data)) {
                $this->Flash->success(__('Motivo Registrado'));
                return $this->redirect(array('controller' => 'Motivos',
                'action' => 'gerenciarmotivos'));
            }
        }
        $this->set('motivs', $this->Motivo->find('all'));
    }
    
    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->Motivo->delete($id)) {
            $this->Flash->success(
                __('Motivo de id: %s foi deletado.', h($id))
            );
            return $this->redirect(array('controller' => 'Motivos',
                'action' => 'gerenciarmotivos'));
        } else {
            $this->Flash->error(
                __('Motivo de id: %s não pode ser deletado deletado.', h($id))
            );
        }
    }
}