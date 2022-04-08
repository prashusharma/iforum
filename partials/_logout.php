<?php
session_start();
echo "Logging you out. Please wati...";
session_destroy();
header("Location:/itforum");

?>