<?php

require_once "Records/invite.php";

echo Invite::Create(Auth::Obj()->User())->Code();

?>