# MiniSprite

[![Build Status](https://travis-ci.org/romanmatyus/MiniSprite.svg)](https://travis-ci.org/romanmatyus/MiniSprite)
[![Code Quality](https://scrutinizer-ci.com/g/romanmatyus/MiniSprite/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/romanmatyus/MiniSprite/)

MiniSprite is library for automatized generating CSS Sprites from CSS definitions.

## Requirements

MiniSprite requires PHP 5.3.3 or later.

## How does this work?

- Configure.
- Parse CSS input.
- Create Sprite image folding proposals.
- Select winner proposal.
- Generate Sprite images.
- Regenerate content of CSS input and return it.

## Installation

The best way to install MiniSprite is use [Composer](http://doc.nette.org/composer) package [`rm/minisprite`](https://packagist.org/packages/rm/minisprite) or manual download the latest ZIP package from [GitHub](https://github.com/romanmatyus/MiniSprite/archive/master.zip).

The downloaded package includes the following directories:

- `src`: this directory contains the source code of MiniSprite. This is
	the only directory that you will need in order to deploy your application.

- `tests`: contains MiniSprite unit tests. Tests is too usable as examples od use case.

## Getting started

```
namespace MiniSprite;

require __DIR__ . '/MiniSprite/vendor/autoload.php';

$miniSprite = new MiniSprite;

// Configuration of Minisprite.
$miniSprite->setImageDirSource("http://www.umb.sk"); // Base path for searching images in CSS content.
$miniSprite->setImageDirOutput("./"); // Directory for saving sprite images.
$miniSprite->setImageDirOutputCss("./"); // Relative path for link of sprite images in regenerated CSS content.

// Registration of folding algorithms.
$miniSprite->addFolder(new HorizontalFolder);
$miniSprite->addFolder(new VerticalFolder);

// Registration of analyzer for winner selection.
$miniSprite->setAnalyzer(new MinimalAreaAnalyzer);

// Call compilation.
// In the variable $newCSS is content of regenerated CSS input.
$newCss = $miniSprite->compile(file_get_contents("http://www.umb.sk/umb/umbbb.nsf/styl.css"));
```

## Contributing

- Use it!
- Write bug reports of ideas into [Issue tracker](https://github.com/romanmatyus/MiniSprite/issues).
- Fork repos and send pull requests with number of issue, source code and tests.

## Todo

- Find and solve bugs.
- Create new folding algorithms.
- Create online API.
- Propagate.

## Contact

Roman Mátyus <romanmatyus@romiix.org>