<?php

// ****
// ****
// Legacy Notice
// This file is conforms to a very bad design. The new one is much better,
// but this file is part of a component that is going to be scrapped anyway.
// For a better example, look at the Views/Components/cube/ folder.
// ****
// ****

require_once "Records/invite.php";

echo Invite::Create(Auth::Obj()->User())->Code();

?>