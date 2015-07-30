<?php 
$I = new FunctionalTester($scenario);

$I->am('A Guest');
$I->wantTo('SignUp for a Knight of Sorrow Account.');

$I->amOnPage('/');
$I->click('Register');
$I->seeCurrentUrlEquals('/auth/register');

$I->fillField('username','testuser');
$I->fillField('email','testuser@localhost.com');
$I->fillField('name','Test User');
$I->fillField('password','secret');
$I->fillField('password_confirmation','secret');
$I->click('.register-btn');
$I->seeCurrentUrlEquals('/home');
$I->assertTrue(Auth::check());