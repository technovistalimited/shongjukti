<?php
/**
 * Shongjukti Facade.
 *
 * A facade mediate for Shongjukti package.
 *
 * @package    laravel
 * @subpackage shongjukti
 */

namespace Technovistalimited\Shongjukti\Facades;

use Illuminate\Support\Facades\Facade;

class Shongjukti extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'shongjukti';
	}
}
