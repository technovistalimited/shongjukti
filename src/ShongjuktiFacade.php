<?php
/**
 * Shongjukti Facade.
 *
 * A facade mediate for Shongjukti package.
 *
 * @package    laravel
 * @subpackage shongjukti
 */

namespace Technovistalimited\Shongjukti;

use Illuminate\Support\Facades\Facade;

class ShongjuktiFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'shongjukti';
	}
}
