<?php 

namespace MiniSprite;

/**
* Image prototype for MiniSprite generator.
*
* @author Roman Mátyus
* @copyright (c) Roman Mátyus 2014
* @license MIT
*/
class Image
{
	const NORMAL = "normal";

	const HORIZONTAL = "horizontal";

	const VERTICAL = "vertical";

	const WITHOUT = "without";

	/** @var string */
	protected $url;

	/** @var resource */
	protected $content;

	/** @var CssBlock */
	protected $cssBlock;

	/** @var int */
	protected $size;

	/** @var string */
	protected $repeating;

	/** @var string */
	protected $width;

	/** @var string */
	protected $height;

	/** @int */
	public $positionX;

	/** @int */
	public $positionY;

	public function __construct($url, CssBlock $cssBlock)
	{
		$this->url = $url;
		$this->cssBlock = $cssBlock;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @return resource
	 */
	public function getContent()
	{
		if (!is_null($this->content)) {
			$this->content;
		} else {
			$resource = file_get_contents($this->url);
			$this->size = strlen($resource);
			$this->content = imagecreatefromstring($resource);
		}
		return $this->content;
	}

	/**
	 * @return CssBlock
	 */
	public function getCssBlock()
	{
		return $this->cssBlock;
	}

	/**
	 * @return integer
	 */
	public function getSize()
	{
		if (is_null($this->size))
			$this->getContent(); // Get size in one request
		return $this->size;
	}

	/**
	 * @return string
	 */
	public function getRepeating()
	{
		if (is_null($this->repeating)) {
			switch ($this->cssBlock->{"background-repeat"}) {
				case "no-repeat":
					$this->repeating = self::NORMAL;
					break;
				case "repeat-x":
					$this->repeating = self::HORIZONTAL;
					break;
				case "repeat-y":
					$this->repeating = self::VERTICAL;
					break;
				default:
					$this->repeating = self::WITHOUT;
					break;
			}
		}
		return $this->repeating;
	}

	/**
	 * @return integer
	 */
	public function getWidth()
	{
		return (!is_null($this->width))
			? $this->width
			: imagesx($this->getContent());
	}

	/**
	 * @return integer
	 */
	public function getHeight()
	{
		return (!is_null($this->height))
			? $this->height
			: imagesy($this->getContent());
	}

	public function __clone()
	{
		$this->cssBlock = clone $this->cssBlock;
	}
}