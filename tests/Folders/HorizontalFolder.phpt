<?php

namespace MiniSprite;

require __DIR__ . '/../bootstrap.php';

use \Tester\Assert;
use \Tester\TestCase;

/**
 * @testCase
 */
class HorizontalFolderTest extends TestCase
{
	public function testOne() {
		$images = array();

		$cssDef = 'div#google {
			background:url(../images/google.png) 0 0 no-repeat;
		}';
		$cssBlock = new CssBlock($cssDef);
		$images[] = new Image("../assets/google.png", $cssBlock);

		$cssDef = 'div#twitter {
			background:url(../images/twitter.png) 0 0 no-repeat;
		}';
		$cssBlock = new CssBlock($cssDef);
		$images[] = new Image("../assets/twitter.png", $cssBlock);

		$cssDef = 'div#youtube {
			background:url(../images/youtube.png) 0 0 no-repeat;
		}';
		$cssBlock = new CssBlock($cssDef);
		$images[] = new Image("../assets/youtube.png", $cssBlock);

		$folder = new HorizontalFolder;
		$folds = $folder->generate($images);
		foreach ($folds as $fold) {
			Assert::type("Minisprite\\Fold", $fold);	
		}

		Assert::equal(96, $folds[Image::NORMAL]->getWidth());
		Assert::equal(32, $folds[Image::NORMAL]->getHeight());
	}

	public function testTwo() {
		$images = array();

		$images[] = new Image(
			"../assets/100x200.png", 
			new CssBlock('div#block1 {background:url(../images/100x200.png) 0 0 no-repeat;}')
		);

		$images[] = new Image(
			"../assets/300x150-2.png", 
			new CssBlock('div#block2 {background:url(../images/300x150-2.png) -25px -25px no-repeat;}')
		);

		$images[] = new Image(
			"../assets/300x150-2.png", 
			new CssBlock('div#block3 {background:url(../images/300x150-2.png) -175px -25px no-repeat;}')
		);

		$images[] = new Image(
			"../assets/200x100.png", 
			new CssBlock('div#block2 {background:url(../images/200x100.png) 0px 0px no-repeat;}')
		);

		$folder = new HorizontalFolder;
		$folds = $folder->generate($images);
		foreach ($folds as $fold) {
			Assert::type("Minisprite\\Fold", $fold);
		}

		Assert::equal(600, $folds[Image::NORMAL]->getWidth());
		Assert::equal(200, $folds[Image::NORMAL]->getHeight());

		$images = $folds[Image::NORMAL]->getImages();

		Assert::equal("0 0", $images[0]->getCssBlock()->{"background-position"});
		Assert::equal(0, $images[0]->positionX);
		Assert::equal(0, $images[0]->positionY);

		Assert::equal("-125px -25px", $images[1]->getCssBlock()->{"background-position"});
		Assert::equal(100, $images[1]->positionX);
		Assert::equal(0, $images[1]->positionY);

		Assert::equal("-275px -25px", $images[2]->getCssBlock()->{"background-position"});
		Assert::equal(100, $images[2]->positionX);
		Assert::equal(0, $images[2]->positionY);

		Assert::equal("-400px 0", $images[3]->getCssBlock()->{"background-position"});
		Assert::equal(400, $images[3]->positionX);
		Assert::equal(0, $images[3]->positionY);
	}
}

$testCase = new HorizontalFolderTest;
$testCase->run();