
<?php
if (function_exists('mb_strtolower')) {
    echo "✅ mbstring is enabled.";
} else {
    echo "❌ mbstring is still NOT enabled.";
}
?>
