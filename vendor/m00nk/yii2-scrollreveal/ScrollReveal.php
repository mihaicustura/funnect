<?php
/**
 * @author Dmitrij "m00nk" Sheremetjev <m00nk1975@gmail.com>
 * Date: 2/3/18, Time: 1:15 AM
 */

namespace m00nk\scrollreveal;

use Yii;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

class ScrollReveal extends Widget
{
	/** @var string CSS-селектор объектов */
	public $selector;

	/** @var int задержка между анимациями в секвенции */
	public $seqDelay = 0;

	/** @var string направление "откуда" движется объект. Значения: 'bottom', 'left', 'top', 'right' */
	public $origin = 'bottom';

	// Can be any valid CSS distance, e.g. '5rem', '10%', '20vw', etc.
	public $distance = '20px';

	// Time in milliseconds.
	public $duration = 500;

	public $delay = 0;

	// Starting angles in degrees, will transition from these values to 0 in all axes.
	public $rotate = ['x' => 0, 'y' => 0, 'z' => 0];

	// Starting opacity value, before transitioning to the computed opacity.
	public $opacity = 0;

	// Starting scale value, will transition from this value to 1
	public $scale = 0.9;

	// Accepts any valid CSS easing, e.g. 'ease', 'ease-in-out', 'linear', etc.
	public $easing = 'cubic-bezier(0.6, 0.2, 0.1, 1)';

	// `<html>` is the default reveal container. You can pass either:
	// DOM Node, e.g. document.querySelector('.fooContainer')
	// Selector, e.g. '.fooContainer'
	public $container = 'window.document.documentElement';

	// true/false to control reveal animations on mobile.
	public $mobile = true;

	// true:  reveals occur every time elements become visible
	// false: reveals occur once as elements become visible
	public $reset = false;

	// 'always' — delay for all reveal animations
	// 'once'   — delay only the first time reveals occur
	// 'onload' - delay only for animations triggered by first load
	public $useDelay = 'always';

	// Change when an element is considered in the viewport. The default value
	// of 0.20 means 20% of an element must be visible for its reveal to occur.
	public $viewFactor = 0.2;

	// Pixel values that alter the container boundaries.
	// e.g. Set `{ top: 48 }`, if you have a 48px tall fixed toolbar.
	// --
	// Visual Aid: https://scrollrevealjs.org/assets/viewoffset.png
	public $viewOffset = ['top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0];


	public function run()
	{
		$view = $this->getView();

		$_ = Yii::$app->assetManager->publish($this->getViewPath().'/assets');
		$view->registerJsFile($_[1].'/scrollreveal.min.js', ['position' => View::POS_HEAD]);

		$options = [
			'origin' => $this->origin,
			'distance' => $this->distance,
			'duration' => $this->duration,
			'delay' => $this->delay,
			'rotate' => $this->rotate,
			'opacity' => $this->opacity,
			'scale' => $this->scale,
			'easing' => $this->easing,
			'container' => new JsExpression($this->container),
			'mobile' => $this->mobile,
			'reset' => $this->reset,
			'useDelay' => $this->useDelay,
			'viewFactor' => $this->viewFactor,
			'viewOffset' => $this->viewOffset,
		];

		$view->registerJs('sr.reveal("'.$this->selector.'", '.Json::encode($options).', '.$this->seqDelay.');');
	}
}