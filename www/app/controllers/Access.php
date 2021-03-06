<?php

/*
 * The Access Controller
 * Link http://github.com/typefo/pbx-mon
 * By typefo <typefo@qq.com>
 */

class AccessController extends Yaf\Controller_Abstract {

    public function statusAction() {
        $access = new AccessModel();
        $this->getView()->assign("data", $access->getAll());
        return true;
	}

    public function createAction() {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $access = new AccessModel();
            $access->create($request->getPost());
            $url = 'http://' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . '/access/status';
            $response = $this->getResponse();
            $response->setRedirect($url);
            $response->response();
            return false;
        }
        
        return true;
    }

    public function editAction() {
        $request = $this->getRequest();
        $access = new AccessModel();

        if ($request->isPost()) {
            $access->change($request->getQuery('id'), $request->getPost());
            $url = 'http://' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . '/access/status';
            $response = $this->getResponse();
            $response->setRedirect($url);
            $response->response();
            return false;
        }
        
        $this->getView()->assign('data', $access->get($request->getQuery('id')));
        return true;
    }

    public function deleteAction() {
        $id = $this->getRequest()->getQuery('id');
        $access = new AccessModel();

        $access->delete($id);

        return false;
    }
}


