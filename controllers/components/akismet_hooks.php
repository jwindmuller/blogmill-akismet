<?php
App::import('Component', 'Akismet.Akismet');
class AkismetHooksComponent extends BlogmillHookComponent {
    private $urls_for_actions = array();

    public function __construct() {
        $this->urls_for_actions = array(
            'comment_list' => array(
                array(
                    'label' => __('Detect all Spam', true),
                    'url' => array('detect_spam')
                ),
                array(
                    'label' => __('Delete all Spam', true),
                    'url' => array('detect_spam', 'delete')
                )
            )
        );
    }

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

    public function actions_for($params) {
        list($location, $urls) = $params;
        if (isset($this->urls_for_actions[$location])) {
            $urls['Akismet'] = $this->urls_for_actions[$location];
        }
        $params[1] = $urls;
    }
}