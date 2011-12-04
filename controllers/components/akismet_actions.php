<?php
App::import('Component', 'BlogmillAction');
App::import('Component', 'Akismet.Akismet');
class AkismetActionsComponent extends BlogmillActionComponent {

    public function detect_spam($controller, $extra) {
        if ($controller->name !== 'Comments') return;
        $delete = isset($extra[0]) && $extra[0] == 'delete';
        $controller->Comment->recursive = -1;
        $conditions = array('spam' => false);
        if ($delete) {
            $conditions = array('approved' => false);
        }
        $comments = $controller->Comment->find('all', compact('conditions'));
        foreach ($comments as $comment) {
            $akismet = AkismetComponent::newAkismet($comment);
            if ($akismet->isCommentSpam()) {
                $akismet->submitSpam();
                if ($delete) {
                    $controller->Comment->delete($comment['Comment']['id']);
                } else {
                    $comment['Comment']['spam'] = true;
                    $controller->Comment->save($comment);
                }
            }
        }
    }
}