<?php
function cifrar($p)
{
	return sha1(md5($p));
}

function cifrarCred($p, $ctr)
{
	return cifrar($p . $ctr);
}

function descrifrarCred($p1, $p2, $ctr)
{
	return (cifrarCred($p1, $ctr) === $p2);
}
