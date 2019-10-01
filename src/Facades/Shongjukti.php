<?php

namespace Technovistalimited\Shongjukti\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Shongjukti Facade Class.
 *
 * @category   Facade
 * @package    Laravel
 * @subpackage TechnoVistaLimited/Shongjukti
 * @author     Mayeenul Islam <wz.islam@gmail.com>
 * @license    MIT (https://opensource.org/licenses/MIT)
 * @link       https://github.com/technovistalimited/shongjukti/
 */
class Shongjukti extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shongjukti';
    }
}
