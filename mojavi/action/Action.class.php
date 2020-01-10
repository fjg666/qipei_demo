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
 * 操作允许您将应用程序和业务逻辑从演示文稿中分离出来。通过提供框架所使用的核心方法集，可以实现安全和验证形式的自动化。
 * Action allows you to separate application and business logic from your
 * presentation. By providing a core set of methods used by the framework,
 * automation in the form of security and validation can occur.
 *
 * @package    mojavi
 * @subpackage action
 *
 * @author    Sean Kerr (skerr@mojavi.org)
 * @copyright (c) Sean Kerr, {@link http://www.mojavi.org}
 * @since     1.0.0
 * @version   $Id: Action.class.php 665 2004-12-15 04:31:19Z seank $
 */
abstract class Action extends MojaviObject{

    // +-----------------------------------------------------------------------+
    // | PRIVATE VARIABLES                                                     |
    // +-----------------------------------------------------------------------+

    private
        $context = null;

    // +-----------------------------------------------------------------------+
    // | METHODS                                                               |
    // +-----------------------------------------------------------------------+

    /**
     * 执行此操作的任何应用程序/业务逻辑。
     * Execute any application/business logic for this action.
     *
     * 在典型的数据库驱动应用程序中，Excel（）处理应用程序本身的逻辑，然后继续创建模型实例。一旦初始化了模型实例，它就处理该操作的所有业务逻辑。
     * In a typical database-driven application, execute() handles application
     * logic itself and then proceeds to create a model instance. Once the model
     * instance is initialized it handles all business logic for the action.
     *
     * 模型应该代表应用程序中的实体。这可能是用户帐户，购物车，甚至像单个产品一样简单的东西。
     * A model should represent an entity in your application. This could be a
     * user account, a shopping cart, or even a something as simple as a
     * single product.
     *
     * 将包含与此操作关联的视图名称的字符串混合。
     * @return mixed A string containing the view name associated with this
     *               action.
     *
     *               Or an array with the following indices:
     *
     *               - The parent module of the view that will be executed.(将执行的视图的父模块。)
     *               - The view that will be executed(将执行的视图.)
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  1.0.0
     */
    abstract function execute ();

    // -------------------------------------------------------------------------

    /**
     * 检索当前应用程序上下文
     * Retrieve the current application context.
     *
     * @return Context The current Context instance.
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  3.0.0
     */
    public final function getContext ()
    {

        return $this->context;

    }

    // -------------------------------------------------------------------------

    /**
     * 检索访问此操作所需的凭据。
     * Retrieve the credential required to access this action.
     *
     * @return mixed Data that indicates the level of security for this action.
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  3.0.0
     */
    public function getCredential (){
        return null;
    }

    // -------------------------------------------------------------------------

    /**
     * 检索此操作不提供给定请求时要执行的默认视图。
     * Retrieve the default view to be executed when a given request is not
     * served by this action.
     * 将包含与此操作关联的视图名称的字符串混合。
     * @return mixed A string containing the view name associated with this
     *               action.
     *
     *               Or an array with the following indices:
     *
     *               - The parent module of the view that will be executed.
     *               - The view that will be executed.
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  1.0.0
     */
    public function getDefaultView (){
        return View::INPUT;
    }

    // -------------------------------------------------------------------------

    /**
     * 检索此操作将处理验证和执行的请求方法。
     * Retrieve the request methods on which this action will process
     * validation and execution.
     *
     * @return int One of the following values:
     *
     *             - Request::GET
     *             - Request::POST
     *             - Request::NONE
     *
     * @see Request
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  1.0.0
     */
    public function getRequestMethods (){
        return Request::GET | Request::POST;
    }

    // -------------------------------------------------------------------------

    /**
     * 执行任何验证后错误应用程序逻辑。
     * Execute any post-validation error application logic.
     *
     * @return mixed A string containing the view name associated with this
     *               action.
     *
     *               Or an array with the following indices:
     *
     *               - The parent module of the view that will be executed.
     *               - The view that will be executed.
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  2.0.0
     */
    public function handleError ()
    {

        return View::ERROR;

    }

    // -------------------------------------------------------------------------

    /**
     * 初始化此操作。
     * Initialize this action.
     *
     * @param Context The current application context.
     *
     * @return bool true, if initialization completes successfully, otherwise
     *              false.
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  2.0.0
     */
    public function initialize ($context)
    {

        $this->context = $context;

        return true;

    }

    // -------------------------------------------------------------------------

    /**
     * 指示此操作需要安全性。
     * Indicates that this action requires security.
     *
     * @return bool true, if this action requires security, otherwise false.
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  1.0.0
     */
    public function isSecure ()
    {

        return false;

    }

    // -------------------------------------------------------------------------

    /**
     * 手动注册此动作的验证器。
     * Manually register validators for this action.
     *
     * @param ValidatorManager A ValidatorManager instance.
     *
     * @return void
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  1.0.0
     */
    public function registerValidators ($validatorManager)
    {

    }

    // -------------------------------------------------------------------------

    /**
     * 手动验证文件和参数。
     * Manually validate files and parameters.
     *
     * @return bool true, if validation completes successfully, otherwise false.
     *
     * @author Sean Kerr (skerr@mojavi.org)
     * @since  1.0.0
     */
    public function validate ()
    {

        return true;

    }

}

?>