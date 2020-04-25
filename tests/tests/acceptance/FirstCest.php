<?php 

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    // tests
    public function seeInSource(AcceptanceTester $I)
    {
        $I->canSeeInSource('header.php');
        $I->canSeeInSource('content.php');
        $I->canSeeInSource('site-info.php');
        
    }
    // public function dontSeeEmoji(AcceptanceTester $I)
    // {
    //     $I->dontSeeInSource('window._wpemojiSettings');
    //     $I->dontSeeInSource('img.wp-smiley');
    // }
    // public function dontSeeBlockEditor(AcceptanceTester $I)
    // {
    //     $I->dontSeeInSource('wp-block-library-css');
    // }
}
