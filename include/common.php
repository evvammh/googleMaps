<?
if (!empty($_POST)) 
{
	reset($_POST);
	while (list($k,$v) = each($_POST))
	{
		${$k} = $v;
	}
}
if (!empty($_GET))
{
	reset($_GET);
	while (list($k,$v) = each($_GET)) 
	{
		${$k} = $v;
	}
}
if (!empty($_SERVER)) 
{
	reset($_SERVER);
	while (list($k,$v) = each($_SERVER))
	{
		${$k} = $v;
	}
}
if (!empty($_COOKIE)) 
{
	reset($_COOKIE);
	while (list($k,$v) = each($_COOKIE)) 
	{
		${$k} = $v;
	}
}
if (!empty($_SESSION)) 
{
	reset($_SESSION);
	while (list($k,$v) = each($_SESSION)) 
	{
		${$k} = $v;
	}
}
if (!empty($_FILES)) 
{
	reset($_FILES);
	while (list($k,$v) = each($_FILES)) 
	{
		${$k} = $v['tmp_name'];
		${$k._name} = $v['name'];
		${$k._type} = $v['type'];
		${$k._size} = $v['size'];
		${$k._error} = $v['error'];
	}
}
?>