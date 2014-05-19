<?php 

namespace MiniSprite;

/**
* @author Roman Mátyus
* @copyright (c) Roman Mátyus 2014
* @license MIT
*/
class HorizontalFolder implements IFolder
{
	public function generate(array $images)
	{
		$_imagesList = array();
		$_imagesProcessed = array();
		$coordinateX = 0;

		// filter usable files
		foreach ($images as $image) {
			if ($image->getCssBlock()->{"background-position"}===NULL) {
				$image->getCssBlock()->{"background-position"} = "0 0";
			} else {
				$position = CssBlock::parseBackgroundPosition($image->getCssBlock()->{"background-position"});
				if (
					!preg_match("/\d{1,}\s*(px)?/i",$position["horizontal"])&&
					!preg_match("/\d{1,}\s*(px)?/i",$position["vertical"])
				)
					continue;
			}
			$_imagesList[$image->getRepeating()][] = clone $image;
		}

		if (isset($_imagesList[Image::NORMAL])) {
			foreach ($_imagesList[Image::NORMAL] as $image) {
				$position = CssBlock::parseBackgroundPosition($image->getCssBlock()->{"background-position"});
				
				foreach ($position as $type => $value)
					$position[$type] = trim(str_replace("px", NULL, $value));

				$sameImage = (isset($_imagesProcessed[Image::NORMAL]))
					? $this->findByUrl($_imagesProcessed[Image::NORMAL], $image->getUrl())
					: NULL;

				if(is_null($sameImage)) {
					$image->positionX = $coordinateX;
					$image->positionY = 0;
					$image->getCssBlock()->{"background-position"} = (-1*$coordinateX+$position["horizontal"]) . "px ".$position["vertical"]."px";
					$coordinateX += $image->getWidth();
				} else {
					$image->positionX = $sameImage->positionX;
					$image->positionY = $sameImage->positionY;
					$image->getCssBlock()->{"background-position"} = (-1*$sameImage->positionX+$position["horizontal"]) . "px ".(-1*$sameImage->positionY+$position["vertical"])."px";
				}
				$_imagesProcessed[$image->getRepeating()][] = $image;
			}
			return array(
				Image::NORMAL => new Fold($_imagesProcessed[Image::NORMAL]),
			);
		}
	}

	private function findByUrl($images, $url)
	{
		foreach ($images as $image) {
			if ($image->getUrl() === $url)
				return $image;
		}
		return NULL;
	}
}
