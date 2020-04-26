<?php 

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }
    
    public function seeFooterFileNameInSource(AcceptanceTester $I) {
        $I->canSeeInSource('header.php');
        $I->canSeeInSource('footer.php');
    }

    // tests
    public function seeInSource(AcceptanceTester $I)
    {
//        $I->canSeeElement('.show-template-name');
//        $I->canSeeInSource('テンプレート');
//        $I->canSeeInSource('header.php');
//        $I->seeInSource('ab-sub-wrapper');
//        $I->canSeeInSource('content.php');
//        $I->canSeeInSource('site-info.php');
//        $I->canSeeInSource('sct::footer.php');
        
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
