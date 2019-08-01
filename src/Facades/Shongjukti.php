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
 * @license    GPL3 (http://www.gnu.org/licenses/gpl-3.0.html)
 * @link       https://github.com/technovistalimited/shongjukti/
 */
class Shongjukti extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shongjukti';
    }
}
