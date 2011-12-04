<?php
App::import('Component', 'Akismet.Akismet');
class AkismetHooksComponent extends BlogmillHookComponent {

    public function before_comment(&$comment_data) {
        $akismet = AkismetComponent::newAkismet($comment_data);
        $comment_data['Comment']['spam'] = $akismet->isCommentSpam();
    }

    public function comment_is_spam($comment_data) {
        $akismet = AkismetComponent::newAkismet($comment_data);
        $akismet->submitSpam();
    }

    public function comment_is_ham($comment_data) {
        $akismet = AkismetComponent::newAkismet($comment_data);
        $akismet->submitHam();
    }
}