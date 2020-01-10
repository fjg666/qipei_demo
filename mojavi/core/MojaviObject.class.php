<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Mojavi package.                                  |
// | Copyright (c) 2003, 2004 Sean Kerr.                                       |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code. You can also view the    |
// | LICENSE file online at http://www.mojavi.org.                             |
// +---------------------------------------------------------------------------+

/**
 * $Id: MojaviObject.class.php 65 2004-10-26 03:16:15Z seank $
 *
 * MOJAVAIL对象提供了所有MOJAVI类继承的有用方法。
 * MojaviObject provides useful methods that all Mojavi classes inherit.
 *
 * @package    mojavi
 * @subpackage core
 *
 * @author    Sean Kerr (skerr@mojavi.org)
 * @copyright (c) Sean Kerr, {@link http://www.mojavi.org}
 * @since     3.0.0
 * @version   $Rev$
 */
abstract class MojaviObject
{

    // +-----------------------------------------------------------------------+
    // | METHODS                                                               |
    // +-----------------------------------------------------------------------+

    /**
     * 检索此对象的字符串表示形式。
     * Retrieve a string representation of this object.
     *
     * 字符串，该字符串包含该对象中可用的所有公共变量。
     * @return string A string containing all public variables available in
     *                this object.
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  3.0.0
     */
    public function toString ()
    {

        $output = '';
        $vars   = get_object_vars($this); // 返回一个数组。获取$object对象中的属性，组成一个数组

        foreach ($vars as $key => &$value)
        {

            if (strlen($output) > 0) // 函数返回字符串 "$output" 的长度
            {

                $output .= ', ';

            }

            $output .= $key . ': ' . $value;

        }

        return $output;

    }

}

?>