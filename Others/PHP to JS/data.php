<?php
// Sample PHP array
$phpArray = array("apple", "banana", "orange");

// Convert PHP array to JSON
$jsonData = json_encode($phpArray);
?>

<script>
    // Pass JSON data to JavaScript variable
    var jsonData = <?php echo $jsonData; ?>;
</script>