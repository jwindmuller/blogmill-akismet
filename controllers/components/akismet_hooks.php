<?php
App::import('Vendor', 'akismet.Akismet');
class AkismetHooksComponent extends Object {
    
    private function newAkismet($comment_data = null) {
        $Setting = ClassRegistry::init('Setting');
        $key = $Setting->get('Akismet.key');
        $blogUrl = Router::url('/', true);
        $akismet = new Akismet($blogUrl, $key);
        
        if ( $comment_data ) {
            extract( $comment_data['Comment'] );
            $akismet->setCommentAuthor($name);
            $akismet->setCommentAuthorEmail($email);
            $akismet->setCommentAuthorURL($url);
            $akismet->setCommentContent($content);
        }
        return $akismet;
    }
    public function before_comment(&$comment_data) {
        $akismet = $this->newAkismet($comment_data);
        $comment_data['Comment']['spam'] = $akismet->isCommentSpam();
    }
    
    public function comment_is_spam($comment_data) {
        $akismet = $this->newAkismet($comment_data);
        $akismet->submitSpam();
    }
}