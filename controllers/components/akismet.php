<?php
App::import('Vendor', 'akismet.Akismet');
class AkismetComponent extends Object {
    public static function newAkismet($comment_data = null) {
        $Setting = ClassRegistry::init('Setting');
        $key = $Setting->get('Akismet.key');
        $blogUrl = Router::url('/', true);
        $akismet = new Akismet($blogUrl, $key);

        if ( $comment_data ) {
            extract( $comment_data );
            $akismet->setCommentAuthor($name);
            $akismet->setCommentAuthorEmail(@$email);
            $akismet->setCommentAuthorURL(@$url);
            $akismet->setCommentContent(@$content);
        }
        return $akismet;
    }
}

