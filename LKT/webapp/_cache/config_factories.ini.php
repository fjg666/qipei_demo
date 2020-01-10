<?php
// auth-generated by FactoryConfigHandler
// date: 12/20/2019 15:21:20

$this->request = Request::newInstance('WebRequest');
$this->storage = Storage::newInstance('SessionStorage');
$this->user = User::newInstance('BasicSecurityUser');
$this->context = new Context($this, $this->request, $this->user, $this->storage, $this->databaseManager);
$this->request->initialize($this->context, null);
$this->storage->initialize($this->context, array('session_name' => 'admin_mojavi'));
$this->user->initialize($this->context, null);

if (MO_USE_SECURITY)
{
	$this->securityFilter = SecurityFilter::newInstance('BasicSecurityFilter');
	$this->securityFilter->initialize($this->context, null);
}

?>